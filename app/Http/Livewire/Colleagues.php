<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Colleague;

class Colleagues extends Component
{
    public $colleagues, $colleague_id, $office_name, $office_address, $office_phone, $appointment_letter, $colleague_name, $colleague_mobile, $colleague_address, $photo;

    public $isOpen = 0;

  

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    public function render()

    {

        $this->colleagues = Colleague::all();

        return view('livewire.colleagues');

    }

  

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    public function create()

    {

        $this->resetInputFields();

        $this->openModal();

    }

  

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    public function openModal()

    {

        $this->isOpen = true;

    }

  

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    public function closeModal()

    {

        $this->isOpen = false;

    }

  

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    private function resetInputFields(){

        $this->colleague_id = '';
        $this->office_name = '';
        $this->office_address = '';
        $this->office_phone = '';
        $this->appointment_letter = '';
        $this->colleague_name = '';
        $this->colleague_mobile = '';
        $this->colleague_address = '';
        $this->photo = '';
       

    }

     

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    public function store()

    {

        $this->validate([
            'office_name' => 'required',
            'office_address' => 'required',
            'office_phone' => 'required',
            'appointment_letter' => 'required',
            'colleague_name' => 'required',
            'colleague_mobile' => 'required',
            'colleague_address' => 'required',
            'photo' => 'required',
        ]);

   

        Colleague::updateOrCreate(['id' => $this->colleague_id], [

            'office_name' => $this->office_name,
            'office_address' => $this->office_address,
            'office_phone' => $this->office_phone,
            'appointment_letter' => $this->appointment_letter,
            'colleague_name' => $this->colleague_name,
            'colleague_mobile' => $this->colleague_mobile,
            'colleague_address' => $this->colleague_address,
            'photo' => $this->photo

        ]);

        session()->flash('message', 
            $this->colleague_id ? 'Colleague Updated Successfully.' : 'Colleague Created Successfully.');
        
        $this->closeModal();
        $this->resetInputFields();
    }

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    public function edit($id)

    {

        $Colleague = Colleague::findOrFail($id);

        $this->colleague_id = $id;
        $this->office_name = $Colleague->office_name;
        $this->office_address = $Colleague->office_address;
        $this->office_phone = $Colleague->office_phone;
        $this->appointment_letter = $Colleague->appointment_letter;
        $this->colleague_name = $Colleague->colleague_name;
        $this->colleague_mobile = $Colleague->colleague_mobile;
        $this->colleague_address = $Colleague->colleague_address;
        $this->photo = $Colleague->photo;

    

        $this->openModal();

    }

     

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    public function delete($id)

    {

        Colleague::find($id)->delete();

        session()->flash('message', 'Colleague Deleted Successfully.');

    }
}
