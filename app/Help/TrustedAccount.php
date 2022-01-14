<?php

namespace App\Help;

use App\Help\Constants\UserType;
use App\Models\TrustedUser;

class TrustedAccount
{

    private $user_type, $is_trusted, $text, $isRequested = false;
    public function __construct($user_type, $user_id)
    {
        $this->user_type = $user_type;
        $find = TrustedUser::where("user_id", $user_id)->first();
        if ($find != null) {
            $this->isRequested = true;
            $this->status = $find->status;
        }
        $this->getBecomeTrusted();
    }
    public function isTrusted()
    {
        return $this->is_trusted;
    }
    public function Text()
    {
        return $this->text;
    }
    private function getBecomeTrusted()
    {

        switch ($this->user_type) {
            case UserType::COMPANY:

                if ($this->isRequested) {
                    $this->text = _i("Trusted Company") . " >> " . $this->status;
                    $this->is_trusted = true;
                } else {
                    $this->text = _i("Become Trusted Company");
                    $this->is_trusted = false;
                }
                break;
            case UserType::USER:
                if ($this->isRequested) {
                    $this->text = _i("Trusted User") . " >> " . $this->status;
                    $this->is_trusted = true;
                } else {
                    $this->text = _i("Become Trusted Company");
                    $this->is_trusted = false;
                }
                break;
            default:
                $this->is_trusted = true;
        }
    }
}
