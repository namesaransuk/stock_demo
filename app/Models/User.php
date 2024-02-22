<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'status',
        'emp_id',
        'record_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isUser($code)
    {
        $status = false;
        // if (strtolower($this->role->code) == $code) {
        //     $status =  true;
        // }
        foreach ($this->userRoles as $userRole) {
            if (strtolower($userRole->role->code) == $code) {
                $status =  true;
            }
        }
        return $status;
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
    //Relation
    //IN [FK]
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
    //OUT [PK]

    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }

    public function userCompanies()
    {
        return $this->hasMany(UserCompany::class, 'user_id');
    }

    //receive material
    public function receiveMaterialStockUsers()
    {
        return $this->hasMany(ReceiveMaterial::class, 'stock_user_id');
    }

    public function receiveMaterialAdminUsers()
    {
        return $this->hasMany(ReceiveMaterial::class, 'admin_user_id');
    }

    //receive packaging
    public function receivePackagingStockUsers()
    {
        return $this->hasMany(ReceivePackaging::class, 'stock_user_id');
    }

    public function receivePackagingAdminUsers()
    {
        return $this->hasMany(ReceivePackaging::class, 'admin_user_id');
    }

    //receive product
    public function receiveProductProductionUsers()
    {
        return $this->hasMany(ReceiveProduct::class, 'production_user_id');
    }

    public function receiveProductStockUsers()
    {
        return $this->hasMany(ReceiveProduct::class, 'stock_user_id');
    }

    //requsition material
    public function requsitionMaterialProductionUsers()
    {
        return $this->hasMany(RequsitionMaterial::class, 'production_user_id');
    }

    public function requsitionMaterialProcurementUsers()
    {
        return $this->hasMany(RequsitionMaterial::class, 'procurement_user_id');
    }

    public function requsitionMaterialStockUsers()
    {
        return $this->hasMany(RequsitionMaterial::class, 'stock_user_id');
    }

    //requsition packaging
    public function requsitionPackagingProductionUsers()
    {
        return $this->hasMany(RequsitionPackaging::class, 'production_user_id');
    }

    public function requsitionPackagingProcurementUsers()
    {
        return $this->hasMany(RequsitionPackaging::class, 'procurement_user_id');
    }

    public function requsitionPackagingStockUsers()
    {
        return $this->hasMany(RequsitionPackaging::class, 'stock_user_id');
    }

    //requsition product
    public function requsitionProductTransportUsers()
    {
        return $this->hasMany(RequsitionProduct::class, 'transport_user_id');
    }

    public function requsitionProductAuditUsers()
    {
        return $this->hasMany(RequsitionProduct::class, 'audit_user_id');
    }

    public function requsitionProductQcUsers()
    {
        return $this->hasMany(RequsitionProduct::class, 'qc_user_id');
    }

    public function requsitionProductStockUsers()
    {
        return $this->hasMany(RequsitionProduct::class, 'stock_user_id');
    }

    //material inspect
    public function materialInspectAuditUsers()
    {
        return $this->hasMany(MaterialInspect::class, 'audit_user_id');
    }

    //packaging inspect
    public function packagingInspectAuditUsers()
    {
        return $this->hasMany(PackagingInspect::class, 'audit_user_id');
    }

    //material inspect
    public function productInspectAuditUsers()
    {
        return $this->hasMany(ProductInspect::class, 'audit_user_id');
    }
}
