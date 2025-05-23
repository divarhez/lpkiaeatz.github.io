use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run()
    {
        Tenant::create([
            'name' => 'Tenant A',
            'logo' => 'path/to/logo_a.png',
            'description' => 'Deskripsi Tenant A',
        ]);

        Tenant::create([
            'name' => 'Tenant B',
            'logo' => 'path/to/logo_b.png',
            'description' => 'Deskripsi Tenant B',
        ]);

        // Tambahkan tenant lainnya sesuai kebutuhan
    }
}
