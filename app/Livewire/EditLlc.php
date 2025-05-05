<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;
use App\Models\Llc;

class EditLlc extends ModalComponent
{
    public $llc;
    public $business_name;
    public $city;
    public $estado;

    public function mount($llc)
    {
        $this->llc = $llc;
        $this->business_name = $llc->business_name;
        $this->city = $llc->city;
        $this->estado = $llc->estado;
    }

    public function save()
    {
        $this->llc->update([
            'business_name' => $this->business_name,
            'city' => $this->city,
            'estado' => $this->estado,
        ]);

        $this->closeModal();
        $this->emit('llcUpdated');
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function render()
    {
        return view('livewire.edit-llc');
    }
}
