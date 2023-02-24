<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUpload;
use App\Models\ConfigFile;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configFile = ConfigFile::all();
        //dd($configFile);

        return view (
            'files.index',
            [
            'files' => $configFile,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileUpload $request)
    {

        //validating for json
        $validated =  $request->validated();
       
        $configFile = ConfigFile::create($validated);
         if($request->hasFile('config')){
            $path = $request->file('config')->store('configFiles');
            $configFile->image()->save(
                 Image::make(['path' => $path])   
            );
         }

        $request->session()->flash('status', 'File uploaded successfully');

        return redirect()->route('files.show',['file'=>$configFile->id]);
    }

    /**
     * Store a newly created merged file resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mergeFiles(Request $request)
    {
    
        // Getting $POST Variables with('image')->
        $title = $_POST['title'];
        $fileIds = $_POST['fileId'];
        $configFiles = ConfigFile::with('image')->whereIn('id',$fileIds)->get();
        $json_files = [];
        $allData = [];
        foreach ($configFiles as $configFile) 
        {
            //json files 
            $json_files[]= Storage::disk('public')->get($configFile->image->path);
            $allData = array_merge($allData,json_decode(Storage::disk('public')->get($configFile->image->path),true));

        }
        
        //Creating and storing the merged JSON file 
        Storage::disk('public')->put('configFiles/'.$title.'.json', json_encode($allData));
        $path = 'configFiles/'.$title.'.json';
       
        //creating records in database for merged JSON file
        $file = new ConfigFile();
        $file->title = $title;
        $file->save();
        $file->image()->save(
            Image::make(['path' => $path])   
       );
        
        $request->session()->flash('status', 'File Merge successfully');

        return redirect()->route('files.show',['file'=>$file->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $configFile = ConfigFile::with('image')->findOrFail($id);
        $json_file = Storage::disk('public')->get($configFile->image->path);
        $json_file = preg_replace('/\r|\n/','',trim($json_file));
        $json = json_decode($json_file, true);
       
        
        return view('files.show',[
            'file'=>ConfigFile::with('image')->findOrFail($id),
            'jsonArray' => $json,
            'json_pretty' => json_encode(json_decode($json_file), JSON_PRETTY_PRINT),

        ]);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = ConfigFile::findOrFail($id);
        $file->delete();
        session()->flash('status',"Config file was deleted!");
        return redirect()->route('files.index');
    }

    /**
     * Search for json value in the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {
        //Getting the JSON array to search
        $configFile = ConfigFile::with('image')->findOrFail($id);
        $json_file = Storage::disk('public')->get($configFile->image->path);
        $json_file = preg_replace('/\r|\n/','',trim($json_file));
        $json = json_decode($json_file, true);

        // Storing the search string.
        $search_string = $_POST['search'];
        $mySearchArray = explode('.', $search_string);
       
        $array = [];

        // Function to check if key entered is present in the JSON array
        function findKey($array, $keySearch)
        {
            foreach ($array as $key => $item) {
                if ($key == $keySearch) {
                    return true;
                } elseif (is_array($item) && findKey($item, $keySearch)) {
                    return true;
                }
            }
            return false;
        }

        foreach($mySearchArray as $key=>$msa){
            if(findKey($json, $msa)){
                if($key ==0){             
                    $array = $json[$msa];
                }else{
                    $array = $array[$msa];     
                }
            }else{
                $array = 'Entered string does not have value';
            }

        }
        
        return view('files.search',[
            'file'=>ConfigFile::with('image')->findOrFail($id),
            'jsonArray' => $json,
            'json_pretty' => json_encode(json_decode($json_file), JSON_PRETTY_PRINT),
            'search_string' => $search_string,
            'search_result' => $array

        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function merge()
    {
        $configFile = ConfigFile::all();
        //dd($configFile);

        return view (
            'files.merge',
            [
            'files' => $configFile,
            ]
        );
    }
}
