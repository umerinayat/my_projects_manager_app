<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use App\Contact;
use App\Product;
use App\ClientChosenProduct;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clients = Client::orderBy('name')->get();
        return ['success' => true, 'clients' => $clients];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());

        if($request['copyMode']) {
            $profile_pic = 'profile-placeholder.png';
        } else {
            $profile_pic = time().'.' . explode('/', explode(':', substr($request->profile_pic, 0, strpos($request->profile_pic, ';')))[1])[1];
            \Image::make($request->profile_pic)->save(public_path('images/').$profile_pic);
        }
    
        $client = Client::create([
            'name' => $request['name'],
            'master_data' => $request['master_data'],
            'notes' => $request['notes'],
            'profile_pic' => $profile_pic
        ]);
        
       if(count($request['contacts']) > 0) 
       {
           foreach($request['contacts'] as $contact ) 
           {
            Contact::create([
                    'first_name' => $contact['first_name'],
                    'last_name' => $contact['last_name'],
                    'email' => $contact['email'],
                    'phone' =>  $contact['phone'],
                    'client_id' => $client->id
                ]);
           }
       } 

        if(count($request['products']) > 0) 
        {
            foreach($request['products'] as $product)
            {
                ClientChosenProduct::create([
                    'product_id' => $product['id'],
                    'client_id' => $client->id
                ]);
            }
        }

        return ['success' => 'true'];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function getClientDetails($id)
    {
        
        $client = Client::findOrFail($id);
    
        $chosenProducts = [];
      
        if($client) 
        {
            $clientChosenProducts = ClientChosenProduct::where('client_id', '=' , $client->id)->get();
            if(count($clientChosenProducts) > 0)
            {
                //dd($clientChosenProducts);

                foreach($clientChosenProducts as $chosenProduct) 
                {
                    $product = Product::findOrFail($chosenProduct->product_id);
                    if($product)
                    {
                        $chosenProducts[] = $product;   
                    }

                }

               
                $client->clientChosenProducts = $chosenProducts;
            }

            $contacts = Contact::where('client_id', '=' , $client->id)->get();
            if(count($contacts) > 0) {
                $client->contacts = $contacts;
            }

            return ['success' => true , 'client' => $client];

        }

    }

    public function FilterClientsByProduct($productId)
    {
        $clientChosenProducts = ClientChosenProduct::where('product_id', '=' , $productId)->get();
        $clients = [];

        if(count($clientChosenProducts) > 0) 
        {
            foreach($clientChosenProducts as $chosenProduct)
            {
                $client = Client::findOrFail($chosenProduct->client_id);
                $clients[] = $client;
            }
        }

        return ['success' => true, 'clients' => $clients];
 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       // dd($request->all());

       if($request['copyMode']) {
        $profile_pic = 'profile-placeholder.png';
        } else {

            try {
                $profile_pic = time().'.' . explode('/', explode(':', substr($request->profile_pic, 0, strpos($request->profile_pic, ';')))[1])[1];
                \Image::make($request->profile_pic)->save(public_path('images/').$profile_pic);
            } catch (\Exception $e) {
                $profile_pic = $request['profile_pic'];
            }
           
        }

        $client = Client::findOrFail($id);
        $client->update([
            'name' => $request['name'],
            'master_data' => $request['master_data'],
            'notes' => $request['notes'],
            'profile_pic' => $profile_pic
        ]);

       Contact::where('client_id', '=' , $id)->delete();
       ClientChosenProduct::where('client_id', '=' , $id)->delete();
        
       if(count($request['contacts']) > 0) 
       {
           foreach($request['contacts'] as $contact ) 
           {
            Contact::create([
                    'first_name' => $contact['first_name'],
                    'last_name' => $contact['last_name'],
                    'email' => $contact['email'],
                    'phone' =>  $contact['phone'],
                    'client_id' => $id
                ]);
           }
       } 

        if(count($request['products']) > 0) 
        {
            foreach($request['products'] as $product)
            {
                ClientChosenProduct::create([
                    'product_id' => $product['id'],
                    'client_id' =>  $id
                ]);
            }
        }

       return ['success' => 'true'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Contact::where('client_id', '=' , $id)->delete();
        ClientChosenProduct::where('client_id', '=' , $id)->delete();
        $client = Client::findOrFail($id);
        $client->delete();

        return ['success' => 'true'];

    }
}
