<?php

namespace twitterapp\model;

use \Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table      = 'tweeter_user';  /* le nom de la table */
    protected $primaryKey = 'id';     /* le nom de la clé primaire */
    public    $timestamps = false;    /* si vrai la table doit contenir
                                            les deux colonnes updated_at,
                                            created_at */
    public function tweets(){
        return $this->hasMany('\twitterapp\model\Tweet','author');
    }
}