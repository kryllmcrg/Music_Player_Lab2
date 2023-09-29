<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MainController extends BaseController
{
    private $playlist;
    private $music;

    public function __construct()
    {
        $this->playlist = new \App\Models\PlaylistModel();
        $this->music = new \App\Models\MusicModel();
    }
    public function index()
    {
        //
    }
    public function view()
    {
        $data = [
            'playlist' => $this->playlist->findAll(),
            'music' => $this->music->findAll(),
        ];
        return view('view', $data);
    }
    public function createPlaylist(){
        $data = [
            'name' => $this->request->getVar('pname'),
        ];
        $this->playlist->save($data);
        return redirect()->to('/view');
    }
    public function addsong()
    {
        $validationRules = [
            'music' => 'uploaded[music]|max_size[music,10240]|mime_in[music,audio/mpeg,audio/mp3]',
        ];
        if ($this->validate($validationRules)) 
        {
            $music = $this->request->getFile('music');
            $musicname = $music->getName();
            $newName = $music->getRandomName();
            $music->move(ROOTPATH . 'public/upload', $newName);
            $data = [
                'title' => $musicname,
                'file_path' => $newName,
                //make sure tama names ng collumns
            ];
            $this->music->insert($data);
            return redirect()->to('/view');
        } else {
            $data['validation'] = $this->validator;
            echo "error";
        }
    }
}
