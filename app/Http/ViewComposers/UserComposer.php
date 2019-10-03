<?php

namespace App\Http\viewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Guard;

class UserComposer
{
  protected $auth;

  public function __construct(Guard $auth)
  {
    $this->auth = $auth;
  }

  public function compose(View $view)
  {
    $view->with('user', $this->auth->user());
  }
}
