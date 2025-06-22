<?php

namespace App\Models\Team\Feedback;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TeamMemberFeedbackEntry extends Model
{
    protected $fillable = [
        'team_member_feedback_id',
        'content',
        "author_id",
        'feedback_type',
        'created_at',
        'updated_at',
    ];

    public function teamMemberFeedback()
    {
        return $this->belongsTo(TeamMemberFeedback::class, 'team_member_feedback_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
