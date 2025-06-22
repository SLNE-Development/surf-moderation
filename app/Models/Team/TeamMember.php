<?php

namespace App\Models\Team;

use App\Models\Team\Feedback\TeamMemberFeedback;
use App\Models\Team\Utils\TeamMemberContactPerson;
use App\Models\Ticket\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $casts = [
        "birth_date" => "datetime",
        "joined_at" => "datetime",
        "exit_date" => "datetime",
    ];

    public function getRouteKeyName()
    {
        return "minecraft_uuid";
    }

    public function getActiveRoleNameAttribute()
    {
        return $this->activeRole()?->role ?? "Keine Rolle";
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function activeRole()
    {
        return $this->hasOne(TeamMemberRole::class, 'team_member_id')
            ->latestOfMany('assigned_at');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('exit_date');
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->whereNotNull('exit_date');
    }

    public function roles()
    {
        return $this->hasMany(TeamMemberRole::class, "team_member_id");
    }

    public function notes()
    {
        return $this->hasMany(TeamMemberNote::class, "team_member_id");
    }

    public function feedback()
    {
        return $this->hasMany(TeamMemberFeedback::class, "team_member_id");
    }

    public function contactPeople()
    {
        return $this->hasMany(TeamMemberContactPerson::class, "team_member_id");
    }

    public function contactPerson()
    {
        return $this->hasOne(TeamMemberContactPerson::class, "contact_person_id");
    }

    public function closedTickets()
    {
        return $this->hasMany(Ticket::class, "closed_by_id", "discord_id")
            ->whereNotNull("closed_at")
            ->orderBy("closed_at", "desc");
    }
}
