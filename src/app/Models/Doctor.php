<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Doctor
 * 
 * @property int $id
 * @property int $user_id
 * @property bool|null $verified_degree
 * @property string $specialty
 * @property Carbon $job_started
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|WorkSchedule[] $work_schedules
 *
 * @package App\Models
 */
class Doctor extends Model
{
	protected $table = 'doctors';

	protected $casts = [
		'user_id' => 'int',
		'verified_degree' => 'bool',
		'job_started' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'verified_degree',
		'specialty',
		'job_started'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function work_schedules()
	{
		return $this->hasMany(WorkSchedule::class);
	}
}
