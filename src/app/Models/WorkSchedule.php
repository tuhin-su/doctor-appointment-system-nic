<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkSchedule
 * 
 * @property int $id
 * @property int $doctor_id
 * @property string $day
 * @property time without time zone $start_time
 * @property time without time zone $end_time
 * @property time without time zone $break_start
 * @property time without time zone $break_end
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Doctor $doctor
 *
 * @package App\Models
 */
class WorkSchedule extends Model
{
	protected $table = 'work_schedule';

	protected $casts = [
		'doctor_id' => 'int',
		'start_time' => 'string',
		'end_time' => 'string',
		'break_start' => 'string',
		'break_end' => 'string',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'doctor_id',
		'day',
		'start_time',
		'end_time',
		'break_start',
		'break_end',
		'enabled'
	];

	public function doctor()
	{
		return $this->belongsTo(Doctor::class);
	}
}
