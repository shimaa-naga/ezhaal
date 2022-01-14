<?php

namespace App;

use App\Help\Constants\BidStatus;
use App\Help\Constants\DiscountModule;
use App\Help\Constants\PaymentStatus;
use App\Help\Constants\ProjectStatus;
use App\Models\Projects\BidStatus as BidStatusModel;
use App\Help\Constants\TransactionStatus;
use App\Help\Constants\TransactionType;
use App\Models\Projects\BidCommission;
use App\Models\Projects\ProjectBids;
use App\Models\Projects\ProjectHistory as ProjectHistoryModel;
use App\Models\Projects\ProjStatus;
use App\Models\SiteSettings\Commissions;
use App\Models\Transactions\Transaction as TransactionsModel;
use App\Models\Transactions\TransactionCommission;
use App\Models\Transactions\TransactionMethod;
use App\Notifications\BidAccepted;
use App\Notifications\FreelancerAccepted;
use App\Traits\Pricing;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Facades\PayPal;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use stdClass;

class Transaction
{

    private  $success = "", $cancel = "", $type = "", $currency = "usd";
    private  const BID = "bid";
    /**
     * @param int $itemId
     * @param float $amount
     * @return string redirect  to paypal
     */
    public function bid($itemId, $amount, $category)
    {
        $this->success = route("payment.success");
        $this->cancel = route("payment.cancel");
        $this->type = self::BID;
        $bidObject = new stdClass();
        $bidObject->itemId = $itemId;
        $bidObject->category = $category;
        $bidObject->total = $amount;
        session()->put($this->type, $bidObject);

        return  $this->PayPal($amount);
    }
    private $transaction;
    public function getTransaction()
    {
        return $this->transaction;
    }
    /**
     * @param \App\Models\Discounts\Discount $discount
     */
    private function checkDiscountAvailabiltiy($discount)
    {
        if ($discount != null)
            if ($discount->module == DiscountModule::SPECIFIC_USER || $discount->module == DiscountModule::PER_USERS || $discount->module == DiscountModule::PER_USER_OPERATIONS) {
                if ($discount->counter > 0)
                    return $discount;
            } else
                return $discount;
        return null;
    }
    public function getBid()
    {
        $bid =  DB::transaction(function () {
            $obj = session()->pull(self::BID);
            if ($obj == null)
                throw (new  Exception("Your session is expired"));
            //$category = $obj->category;
            $itemId = $obj->itemId;
            $bid = ProjectBids::find($itemId);
            $sub = $bid->commession == null ? 0 : $bid->commession;
            $transData = [
                "user_id" => auth("web")->id(),
                "method_id" => TransactionMethod::firstWhere("code", "paypal")->id,
                "total" => $obj->total,
                "currency" => $this->currency,
                "type" => TransactionType::ACCEPTBID,
                "operation" => "credit",
                "trans_number" => $obj->order_id,
                "confirm_number" => request()->query("PayerID"),
                "status" => TransactionStatus::OK,
                "commission" => $sub
            ];
            //discount
            $user_amount  = ( $obj->total-$sub);

            if ($bid->Discount() != null) {
                $discount = $this->checkDiscountAvailabiltiy($bid->Discount());
                if ($discount != null) {
                    $transData["discount_id"] = $discount->id;
                    if ($discount->type == "perc") {
                        $add = $discount->price * $obj->total;
                    } else
                        $add = $discount->price;
                    $user_amount = ($add + $user_amount);
                }
            }
            $transData["user_amount"] = floor($user_amount);
            //token=53671086ND500203R&PayerID=FVFM252TWWB4J
            $trans = TransactionsModel::create($transData);
            $this->transaction = $trans;
            //bid status update
            $bid->status_id = BidStatusModel::firstOrCreate(["title" => BidStatus::ACCEPTED])->id;
            $bid->payment_status = PaymentStatus::PENDING;
            $bid->save();
            //commisions
            $allCommissions = $bid->Commissions()->get();
            //    $trans->Commisions()->attach($allCommissions->pluck("commission_id"), ["amount" => $allCommissions]);
            foreach ($allCommissions as $commission) {
                TransactionCommission::create(["transaction_id" => $trans->id, "commission_id" => $commission->commission_id, "amount" => $commission->amount]);
            }

            $project = $bid->Project();
            $status_id = ProjStatus::firstOrCreate(["title" => ProjectStatus::ASSIGNED])->id;
            ProjectHistoryModel::create([
                "project_id" => $project->id, "bid_id" => $bid->id, "status_id" => $status_id, "transaction_id" => $trans->id,
                "by_id" => auth("web")->id()
            ]);
            $project->update([
                "status_id" => $status_id
            ]);

            return $bid;
        });
        $bid->Freelancer()->notify(new BidAccepted($bid->id));
    }
    /**
     *
     */
    private function Paypal($amount)
    {
        $provider = new PayPalClient();
        // Through facade. No need to import namespaces
        $provider = PayPal::setProvider();
        $config = config("paypal");
        $provider->setApiCredentials($config);
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' =>
            [
                0 =>
                [
                    'amount' =>
                    [
                        'currency_code' => 'USD',
                        'value' => $amount
                    ]
                ]
            ],
            "application_context" => [
                "cancel_url" => $this->cancel,
                "return_url" => $this->success
            ]
        ]);
        dd($response);
        $order_id = $response["id"];
        $obj = session($this->type);
        $obj->order_id = $order_id;
        session($this->type, $obj);

        $link = "";
        $key = array_search('approve', array_column($response["links"], 'rel'));
        $find = ($response["links"][$key]);
        $link = $find["href"];

        return redirect($link);
    }
}
