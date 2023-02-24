<?php

namespace Tests\Feature;

use App\Models\ConfigFile;
use App\Models\Image;
use DateTimeInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class ConfigFileTest extends TestCase
{
    use RefreshDatabase;


        /**
    * Prepare a date for array / JSON serialization.
    *
    * @param  \DateTimeInterface  $date
    * @return string
    */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoConfigFilesWhenNothingInDatabase()
    {
        $response = $this->get('/files');

        $response->assertSeeText('No configs file available.');

        $response->assertStatus(200);
    }

    public function testSeeOneConfigFileWhenThereIs1(){

        //Arrange Part
        $configFile = $this->createDummyConfigFile();
        Image::factory()->create([
            'imageable_id' => $configFile->id,
            'imageable_type' => 'App\Models\ConfigFile',
        ]);

       //Act
       $response = $this->get('/files');

       //Assert
       $response->assertSeeText('New File');

       $this->assertDatabaseHas('config_files',[
            'title' => 'New File'
       ]);

       $this->assertDatabaseHas('images',[
            'imageable_id' => $configFile->id,
            'imageable_type' => 'App\Models\ConfigFile',
        ]);

    }

    public function testUploadJsonFileTest(){

        Storage::fake('public');

        $file = UploadedFile::fake()->create('check.json',512,'application/json');

        // //posting to the store method
        // $result = $this->post(route('files.store'),[
        //     'title' => "New File1",
        //     'config' => $file,
        // ]);

        //Above and below both method works
        $response = $this->json('POST',route('files.store'), [
            'title' => "New File1",
            'config' => $file,
        ]);

        $storedFile =  ConfigFile::with('image')->first();
        $this->assertNotNull($storedFile->image->path);
        $this->assertEquals('New File1',$storedFile->title);

        // Assert the file saved above and stored are the same one
        Storage::disk('public')->assertExists($storedFile->image->path);
        $this->assertFileEquals($file, Storage::disk('public')->path($storedFile->image->path));
        Storage::disk('public')->assertExists('configFiles/'.$file->hashName());

        // Assert a file does not exist
        Storage::disk('public')->assertMissing('configFiles/'.'unavailable_file.json');
    }

    public function testDeleteConfigFile(){
        $configFile = $this->createDummyConfigFile();
        
        $this->assertDatabaseHas('config_files',[
            'title' => 'New File'
        ]);

        $this->delete("/files/{$configFile->id}")->assertStatus(302)->assertSessionHas('status');

        $this->assertEquals(session('status'),'Config file was deleted!');
        $this->assertSoftDeleted('config_files',[
            'title' => 'New File'
        ]);
        //$this->assertSoftDeleted('config_files',$configFile->toArray());
    }

    private function createDummyConfigFile():ConfigFile{
        $file = ConfigFile::factory()->newTitle()->create();
        return $file;
    }
}
