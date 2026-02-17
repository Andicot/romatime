<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RuoliOperatoreEnum;
use App\Http\MieClassi\FunzioniContatti;
use App\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, FunzioniContatti;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function iniziali()
    {
        return $this->nome[0] . $this->cognome[0];
    }

    public function nominativo()
    {
        return $this->nome . ' ' . $this->cognome;
    }

    public function setExtra($value)
    {

        $array = $this->extra;
        foreach ($value as $key => $val) {
            $array[$key] = $val;
        }
        $this->attributes['extra'] = json_encode($array);
        $this->save();

    }


    public function getExtra($key = null)
    {
        if ($key !== null && is_array($this->extra)) {
            if (array_key_exists($key, $this->extra)) {
                return $this->extra[$key];
            }
        }
        return null;
    }

    public function stringToColorCode()
    {
        $str = $this->iniziali();
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);
        return "#$code";
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {

        $this->extra = ['invio_email_verifica' => Carbon::now()->format('d/m/Y H:m:s')];
        $this->save();
        $this->notify(new VerifyEmail());
    }

    public function userLevel($small, $user)
    {

        $livelli = ['operatore', 'admin'];

        foreach ($livelli as $livello) {
            if ($user->permissions->where('nome', $livello)->first()) {
                return $this::labelLivelloOperatore($livello, $small);
            }

        }

    }

    public function badgeRuolo()
    {
        $stato = RuoliOperatoreEnum::tryFrom($this->ruolo);
        return '<span class="badge badge-' . $stato->colore() . ' fw-bolder me-2">' . $stato->testo() . '</span>';
    }

    public function coloreRuolo()
    {
        $stato = RuoliOperatoreEnum::tryFrom($this->ruolo);
        return $stato->colore();
    }
}
