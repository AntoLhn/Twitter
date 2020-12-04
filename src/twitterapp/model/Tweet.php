<?php

namespace twitterapp\model;

use \Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $table      = 'tweeter_tweet';  /* le nom de la table */
    protected $primaryKey = 'id';     /* le nom de la clé primaire */
    public    $timestamps = true;    /* si vrai la table doit contenir
                                            les deux colonnes updated_at,
                                            created_at */
    public function author(){
        return $this->belongsTo('\twitterapp\model\User','author');
    }
}
