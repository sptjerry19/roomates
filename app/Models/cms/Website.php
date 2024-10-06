<?php

namespace App\Models\cms;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Website extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_site_id',
        'site_id',
        'lang_id',
        'companies_id',
        'site_name',
        'site_domain',
        'site_logo1_url',
        'site_logo2_url',
        'langjson',
        'site_title',
        'site_keyword',
        'site_description',
        'site_header',
        'site_hotline',
        'site_footer',
        'site_footer_address',
        'site_footer_phone',
        'site_footer_email',
        'site_footer_version',
        'site_footer_social_url1',
        'site_footer_social_url2',
        'site_footer_social_url3',
        'site_marquee',
        'app_store_url',
        'play_store_url',
        'is_register_ministry_industry_trade',
        'register_ministry_industry_trade_image_url',
        'status',
        'api_demoregister_key',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'companies_id'
    ];
    protected $primaryKey = 'meta_site_id';
    protected $table = 'sites_meta';

    // relationship many to many site_meta with user
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'sites', 'sites_meta_id', 'users_id');
    }

    public function language(): HasOne
    {
        return $this->hasOne(Language::class, 'lang_id', 'lang_id');
    }
}
