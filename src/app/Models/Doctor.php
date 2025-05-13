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

	public function workSchedules()
	{
		return $this->hasMany(\App\Models\WorkSchedule::class, 'doctor_id');
	}

	public function getExperienceTextAttribute()
	{
		$diffInDays = \Carbon\Carbon::now()->diffInDays($this->job_started);

		if ($diffInDays < 30) {
			return floor($diffInDays) . ' Day' . ($diffInDays > 1 ? 's' : '');
		} elseif ($diffInDays < 365) {
			return intdiv($diffInDays, 30) . ' Month' . (intdiv($diffInDays, 30) > 1 ? 's' : '');
		} else {
			return intdiv($diffInDays, 365) . ' Year' . (intdiv($diffInDays, 365) > 1 ? 's' : '');
		}
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function work_schedules()
	{
		return $this->hasMany(WorkSchedule::class);
	}
}
