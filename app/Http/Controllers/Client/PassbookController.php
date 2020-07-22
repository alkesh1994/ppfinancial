<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Client\PassbookService;

class PassbookController extends Controller
{

  private $passbookService;

  public function __construct(PassbookService $passbookService)
  {
    $this->passbookService = $passbookService;
  }

  //To show passbook
  public function show($clientSlug,$accountSlug)
  {

    $showPassbook = $this->passbookService->showPassbook($clientSlug,$accountSlug);

    return $showPassbook;

  }

  //export custom passbook as pdf
  public function exportPassbookPdf(Request $request,$clientSlug,$accountSlug)
  {

    $exportPdf = $this->passbookService->exportPdf($request,$clientSlug,$accountSlug);

    return $exportPdf;

  }

}
