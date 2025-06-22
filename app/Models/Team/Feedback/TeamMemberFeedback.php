<?php

namespace App\Models\Team\Feedback;

use App\Models\Team\TeamMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TeamMemberFeedback extends Model
{
    protected $fillable = [
        'team_member_id',
        'content',
        'created_at',
        'updated_at',
    ];

    public function getOverdueAttribute()
    {
        return $this->due_at && now()->greaterThan($this->due_at) && !$this->closed_at;
    }

    public function getClosedAttribute()
    {
        return !is_null($this->closed_at);
    }

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id');
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function entries()
    {
        return $this->hasMany(TeamMemberFeedbackEntry::class, 'team_member_feedback_id');
    }
}
