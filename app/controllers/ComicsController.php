<?php

class ComicsController extends BaseController
{

    public function create()
    {
        $new = Input::all();
        $series_id = Input::get('series_id');
        $comic = new Comic;
        if ($comic->validate($new)) {
            if($this -> module_state('inventory') == 1)
                $comic->available = Input::get('available');
            if(Input::get('image') != null)
                $comic->image = Input::get('image');
            $comic_price = str_replace(',', '.', Input::get('price'));
            $comic->name = Input::get('name');
            $comic->number = Input::get('number');
            $comic->price = $comic_price;
            $comic->series_id = $series_id;
            $comic->save();
            if(!Input::get('no_follow')){
                $this->updateComicUser($series_id, $comic);
            }
            return Redirect::to('series/' . $series_id);
        } else {
            $errors = $comic->errors();
            return Redirect::to('series/' . $series_id)->withErrors($errors);
        }
    }

    public function update()
    {
        $new = Input::all();
        $id = Input::get('id');
        $comic = Comic::find($id);
        $return = Input::get('return');
        if ($comic->validate($new)) {
            $new_price = Input::get('price');
            $comic->name = Input::get('name');
            $comic->number = Input::get('number');
            if($this -> module_state('inventory') == 1)
                $comic->available = Input::get('available');
            if(Input::get('image') != null)
                $comic->image = Input::get('image');
            if ($new_price != $comic->price) {
                $comic->price = $new_price;
                DB::update('update bm_comic_user set price = ' . $new_price . ' where comic_id = ' . $id . ' and state_id < 3');
            }
//            if (Input::get('active'))
//                $comic->active = 1;
//            else {
//                $comic->active = 0;
//                DB::update('update bm_comic_user set active = 0 where comic_id = ' . $id);
//            }
            $comic->save();

            if ($return == 'comics')
                return Redirect::to('comics/' . $id);
            elseif ($return == 'series')
                return Redirect::to('series/' . $comic->series_id . '/' . $id);
            else
                return "error";
        } else {
            $errors = $comic->errors();
            if ($return == 'comics')
                return Redirect::to('comics/' . $id)->withErrors($errors);
            elseif ($return == 'series')
                return Redirect::to('series/' . $comic->series_id . '/' . $id)->withErrors($errors);
            else
                return "error";
        }

    }

    public function delete()
    {
        $comic_id = Input::get('id');
        $path = Input::get('return');
        $rules = array('id' => 'required|numeric|exists:bm_comics,id,active,1');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to($path)->withErrors($validator);
        } else{
            $comic = Comic::find($comic_id);
            $comic->active = 0;
            $comic->update();
            DB::update('update bm_comic_user set active = 0 where comic_id = ' . $comic_id);
            return Redirect::to($path);
        }
    }

    public function restore(){
        $comic_id = Input::get('id');
        $path = Input::get('return');
        $rules = array('id' => 'required|numeric|exists:bm_comics,id,active,0');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to($path)->withErrors($validator);
        } else{
            $comic = Comic::find($comic_id);
            $comic->active = 1;
            $comic->update();
            return Redirect::to($path);
        }
    }

    public function remove()
    {
        $id = Input::get('id');
        $comic = ComicUser::where('comic_id', '=', $id);
        $comic->active = 0;
        $comic->update();
        return Redirect::to('boxes/' . $comic->series_id . '/' . $id);
    }

    public function updateComicUser($series_id, $comic)
    {
        $series_user = SeriesUser::whereRaw('series_id = ' . $series_id . ' and active = 1')->get();
        foreach ($series_user as $user) {
            $comicUser = new ComicUser;
            $comicUser->comic_id = $comic->id;
            $comicUser->user_id = $user->user_id;
            $comicUser->price = $comic->price;
            $comicUser->save();
        }
    }

    public function listAllComics()
    {
        $inv_state = $this -> module_state('inventory');
        $comics = Comic::all();
        $this->layout->content = View::make('admin/manageComics', array('comics' => $comics,'inv_state' => $inv_state));
    }

    public function showShipmentLoader()
    {
        $inv_state = $this -> module_state('inventory');
        if($inv_state == 1) {
            $comics = Comic::where('active', '=', '1');
            $active_series = DB::select('SELECT s.id, s.name, s.version, count(*) as comics FROM bm_series as s LEFT JOIN bm_comics as c ON c.series_id = s.id WHERE s.active = 1 and c.active = 1 GROUP BY s.id');
        }
        else {
            $comics = Comic::where('state', '=', '1');
            $active_series = DB::select('SELECT s.id, s.name, s.version, c.comics FROM bm_series as s LEFT JOIN (SELECT series_id, count(*) as comics FROM bm_comics WHERE active = 1 AND state = 1 GROUP BY series_id) as c ON c.series_id = s.id WHERE s.active = 1 AND c.comics > 0 ');
        }
        $this->layout->content = View::make('admin/shipmentLoader', array('comics' => $comics, 'active_series' => $active_series,'inv_state' => $inv_state));
    }

    public function loadShipment()
    {
        $inv_state = $this -> module_state('inventory');
        if($inv_state == 1)
            $rules = array('comic_id' => 'required|min:1|integer|exists:bm_comics,id,active,1', 'amount' => 'required|min:1|integer');
        else
            $rules = array('comic_id' => 'required|min:1|integer|exists:bm_comics,id,active,1');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return Redirect::to('newShipment')->withErrors($validator);
        } else {
            $comic_id = Input::get('comic_id');
            $amount = Input::get('amount');
            $comic = Comic::find($comic_id);
            if($inv_state == 1)
                $comic->available += $amount;
            if($comic->state == 1) {
                $comic->arrived_at = date('Y-m-d H-i-s', time());
                $comic->state = 2;
            }
            $comic->update();
            return Redirect::to('newShipment');
        }
    }

    public function getNumberFromSeries()
    {
        $this->layout = null;
        $series_id = Input::get('series_id');
        $inv_state = $this -> module_state('inventory');
//        if($inv_state == 1)
            $comics = Comic::whereRaw('series_id = ' . $series_id . ' and active = 1')->get();
//        else
//            $comics = Comic::whereRaw('series_id = ' . $series_id . ' and active = 1 and state = 1')->get();
        return $comics;
    }

    public function getNewNumbersFromSeries()
    {
        $this->layout = null;
        $series_id = Input::get('series_id');
        $inv_state = $this -> module_state('inventory');
        if($inv_state == 1)
            $comics = Comic::whereRaw('series_id = ' . $series_id . ' and active = 1')->get();
        else
            $comics = Comic::whereRaw('series_id = ' . $series_id . ' and active = 1 and state = 1')->get();
        return $comics;
    }

    public function manageComic($comic_id)
    {
        $inv_state = $this -> module_state('inventory');
        $comic = Comic::find($comic_id);
        $comic->price = round($comic->price,2);
        $ordered = ComicUser::whereRaw('active = 1 AND state_id = 1 AND comic_id = ' . $comic_id)->get();
        if ($comic != null)
            $this->layout->content = View::make('admin/viewComic', array('comic' => $comic, 'path' => '../','ordered' => $ordered,'inv_state' => $inv_state));
        else
            return Redirect::to('comics/' . $comic_id);
    }

    public function module_state($module_description){
        $modules = Modules::where('description','=',$module_description)->get();
        $state = 0;
        if(count($modules)==1) {
            foreach($modules as $module){
                $state = $module->active;
            }
        }
        return $state;
    }
}

?>