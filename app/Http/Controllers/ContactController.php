<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact as ModelsContact;
use App\Services\ContactService;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;


class ContactController extends Controller
{
    //

    use AuthorizesRequests , ValidatesRequests;

    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }


    //on recupere les contactes depuis le service pour le renvoyer a la vue
    public function index()
    {
        $contacts = $this->contactService->getAllContacts();

        return Inertia::render('Dashboard', ['contacts' => $contacts]);
    }

    //affichage de la vue pour créer un contact
    public function create(){

        return Inertia::render('Dashboard',[
            'showModal' => true,
            'modalType' => 'create'
        ]);
    }

    
    // enregistrement d'un contact et redirection 
    public function store(StoreContactRequest $request){

        $validate = $request->validated();
        
        if($request->hasFile('image_path')){
            
            $validate['image_path'] = $request->file('image_path')->store('images', 'public');

        }
    
        $this->contactService->creatContact($validate);
        return Redirect::route('dashboard')->with('success','Contact créé avec succès');

    }


     // affichage en details d'un contact
    public function show(ModelsContact $contact){

        $this->authorize('view', $contact);
        return Inertia::render('ShowContact',[
            'contact' => $contact
        ]);
    }

    // affichage de la vue pour  l'edition d'un contact
    public function edit(ModelsContact $contact){

        $this->authorize('update', $contact);
        return Inertia::render('Dashboard',[
            'showModal' => true,
            'modalType' => 'edit',
            'contact' => $contact
        ]);
    }


    // mise à jour du contact et redirection vers le dashboard
    public function update(ModelsContact $contact, StoreContactRequest $request){

        $this->authorize('update', $contact);
        $validated = $request->validated();
        if ($request->hasFile('image_path')) {
        // Optionnel : supprimer l’ancienne image si elle existe
        if ($contact->image_path) {
            Storage::disk('public')->delete($contact->image_path);
        }

        // Stocker la nouvelle image
        $validated['image_path'] = $request->file('image_path')->store('images', 'public');
        }
        $this->contactService->updateContact($contact,$validated);
        return Redirect::route('dashboard')->with('success','contact mise a jour à avec succès');
        
    }


    //suppression d'un contact et redirection vers la liste des contacts
    public function destroy(ModelsContact $contact){
        $this->authorize('delete', $contact);
        $this->contactService->deleteContact($contact);
        return Redirect::route('dashboard')->with('success','contact supprimé avec succès');
    }



}