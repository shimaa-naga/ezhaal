<?php

namespace App\Http\Controllers\Website\Dashboard;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;
use App\Models\Transactions\TransactionRequest;
use App\Models\TrustedUser;
use App\Notifications\BidAccepted;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  $this->middleware('auth:web,master');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $role = Role::where("name","Master")->first();
       // Notification::send($role,new BidAccepted(6));
        return view('website.dashboard.home');
    }

    public function downloadTrusted($file)
    {
        $path = storage_path("app/uploads/trusted/" . $file);

        try {
            return $this->download($path);
        } catch (FileNotFoundException $exception) {
            abort(404);
        }
    }
    private function download($path)
    {

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
    public function downloadTrustedRequest($id)
    {
        $request = TrustedUser::find($id);
        try {
            $path = ($request->file);
            return $this->download($path);
        } catch (Exception $exception) {
            abort(404);
        }
    }
    public function downloadTransactionRequest($id)
    {
      //  dd($id);
        $request = TransactionRequest::find($id);
        try {
            $path = ($request->statement);
            return $this->download($path);
        }
        catch (Exception $exception) {
            abort(404, $exception->getMessage());
        }
    }
}
