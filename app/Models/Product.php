<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable  = ['name','description'];
    protected $fillables =['name','description','sale_price','purchase_price','categoty_id','stock'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getProfitPercentAttribute(){
        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = $profit * 100 / $this->purchase_price;
        return $profit_percent;
    }
}
