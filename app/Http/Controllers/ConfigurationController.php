<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Requests\MailRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ConfigurationRequest;

class ConfigurationController extends Controller
{

    public function profile()
    {
        if (!$this->hasConfiguration()) {
            $configuration = null;
        } else {
            $configuration = Configuration::find(1);

            if ($configuration['logo']) {
                $configuration['logoUrl'] = asset('storage/' . $configuration['logo']);
            }
        }

        return Inertia::render('Configuration/Profile', compact('configuration'));
    }

    public function mail()
    {
        if (!$this->hasConfiguration()) {
            $configuration = null;
        } else {
            $configuration = Configuration::all()
                ->where('id', 1)
                ->firstOrFail();
        }

        return Inertia::render('Configuration/Mail', compact('configuration'));
    }

    public function submit(ConfigurationRequest $request)
    {
        // Obtener la configuración existente o crear una nueva
        $configuration = Configuration::find(1) ?? new Configuration;

        // Actualizar la configuración con los datos del formulario
        $configuration->fill($request->only([
            'company_name', 'ruc', 'contact_number', 'email', 'address', 'regime_category'
        ]));

        // Si se proporcionó un nuevo logotipo, almacenarlo
        if ($request->hasFile('logo')) {
            // Eliminar el logotipo anterior si existe
            if ($configuration['logo']) {
                Storage::disk('public')->delete($configuration['logo']);
            }

            // Almacenar el nuevo logotipo y guardar la ruta en la base de datos
            $logoPath = $request->file('logo')->store('logos', 'public');
            $configuration['logo'] = $logoPath;
        }

        // Guardar la configuración
        $configuration->save();

        if ($configuration) {
            $type = 'success';
            $message = "Datos actualizados exitosamente";
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Datos no actualizados";
        }

        return to_route('dashboard')->with($type, $message);
    }

    public function submitMail(MailRequest $request)
    {
        $post = $request->validated();

        $post['mail_from_address'] = $post['email'] . (app()->environment('local') ? "@prueba.com" : "");

        if (!$this->hasConfiguration()) {
            $configuration = Configuration::create($post);
        } else {
            $configuration = Configuration::where('id', 1)->firstOrFail();
            $configuration->update($post);
        }

        Config::set('mail.mailers.smtp.transport', $post['mail_mailer']);
        Config::set('mail.mailers.smtp.host', $post['mail_host']);
        Config::set('mail.mailers.smtp.port', $post['mail_port']);
        Config::set('mail.mailers.smtp.username', $post['email']);
        Config::set('mail.mailers.smtp.password', $post['mail_password']);
        Config::set('mail.mailers.smtp.from_address', $post['mail_from_address']);
        Config::set('mail.mailers.smtp.from_name', $post['mail_from_name']);
        Config::set('mail.from.address', $post['mail_from_address']);

        $this->saveMailConfig();

        if ($configuration) {
            $type = 'success';
            $message = "Datos actualizados exitosamente";
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Datos no actualizados";
        }

        return to_route('dashboard')->with($type, $message);
    }

    private function saveMailConfig()
    {
        $configPath = config_path('mail.php');
        $config = var_export(config('mail'), true);

        file_put_contents($configPath, "<?php\n\nreturn $config;");

        // Limpiar y recargar la configuración para que los cambios surtan efecto
        Artisan::call('config:clear');
        Artisan::call('config:cache');
    }

    public function hasConfiguration()
    {
        return Configuration::count() > 0;
    }
}
