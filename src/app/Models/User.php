<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $profile_image
 * @property string $password
 * @property string|null $remember_token
 * @property USER-DEFINED $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Doctor[] $doctors
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use Notifiable;
	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'role' => 'string'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'profile_image',
		'password',
		'remember_token',
		'role'
	];

	public function doctors()
	{
		return $this->hasMany(Doctor::class);
	}
}
