<?php

namespace twitterapp\model;

use \Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table      = 'tweeter_like';  /* le nom de la table */
    protected $primaryKey = 'id';     /* le nom de la clé primaire */
    public    $timestamps = false;    /* si vrai la table doit contenir
                                            les deux colonnes updated_at,
                                            created_at */
}