namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function avis()
    {
        return $this->hasMany(Avis::class); // Relation entre User et Avis
    }

    public function aDejaCommande($articleId)
    {
        return $this->commandes()->whereHas('details', function ($query) use ($articleId) {
            $query->where('id_article', $articleId);
        })->exists();
    }

    public function commandes()
    {
        return $this->hasMany(CommandeEntete::class, 'id_user');
    }
}
