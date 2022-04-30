<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShortCode extends Model
{
    protected $fillable = ['code', 'url', 'unsuspicious'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = $model->generateCode();
        });
    }

    public function generateCode()
    {
        if($this->unsuspicious == true) {
            $code = str_replace("\r\n", "", $this->getRandomWord(3, "-"));
        } else {
            $code = Str::random(6);
        }
        if (ShortCode::where('code', $code)->exists()) {
            return $this->generateCode();
        }
        return $code;
    }

    public function getRandomWord($count, $delimiter) {
        $rand_text = "";    
        for($i = 0; $i < $count; $i++) {
            $file = "words_alpha.txt";
            // Convert the text fle into array and get text of each line in each array index
            $file_arr = file($file);
            // Total number of lines in file
            $num_lines = count($file_arr);
            // Getting the last array index number
            $last_arr_index = $num_lines - 1;
            // Random index number
            $rand_index = rand(0, $last_arr_index);
            // random text from a line. The line will be a random number within the indexes of the array
            if($i > 0) {
                $rand_text .= $delimiter;
            }
            $rand_text .= $file_arr[$rand_index];
        }
        return $rand_text;
    }
}
