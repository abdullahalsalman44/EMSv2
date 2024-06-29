<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\FavoratesServices;

class FavorateController extends Controller
{
    protected $favorateServices;

    public function __construct(FavoratesServices $favorateServices) {
       $this->favorateServices=$favorateServices;
    }

    public function getSalons(){
        return $this->favorateServices->getSalonFavorates();
    }

    public function getDresses(){
        return $this->favorateServices->getDressFavorates();
    }

    public function addToFavorates(Request $request){
        return $this->favorateServices->addToFavorate($request);
    }

    public function deleteFromFavorate(Request $request){
        return $this->favorateServices->deleteFromFavorate($request->all());
    }
}
