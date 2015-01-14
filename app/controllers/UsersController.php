<?php
class UsersController extends BaseController
{

    public function create()
    {
        $new = Input::all();
        $user = new User;
        $user->username = Input::get('username');
        $user->password = Hash::make(Input::get('password'));
        $user->name = Input::get('name');
        $user->surname = Input::get('surname');
        $user->number = Input::get('number');
        $user->discount = Input::get('discount');
        if ($user->validate($new)) {
            $user->save();
            return Redirect::to('boxes/' . $user->id);
        } else {
            $errors = $user->errors();
            return Redirect::to('boxes/' . $user->id)->withErrors($errors);
        }
    }

    public function update()
    {
        $new = Input::all();
        $id = Input::get('id');
        $user = User::find($id);
        $user->name = Input::get('name');
        $user->surname = Input::get('surname');
        $user->number = Input::get('number');
        $new_password = Input::get('pass');
        if ($user->validate($new)) {
            $new_hash = Hash::make($new_password);
            if ($new_hash != $user->password && $new_password != null) {
                $user->password = $new_hash;
            }
            $user->discount = Input::get('discount');
            if (Input::get('active')) {
                $user->active = 1;
            } else {
                $user->active = 0;
                $this->delete($id);
            }
            $user->save();
            return Redirect::to('boxes/' . $id);
        } else {
            $errors = $user->errors();
            return Redirect::to('boxes/' . $id)->withErrors($errors);
        }
    }

    public function delete($box_id)
    {
        //delete followed series and ordered comics
        DB::table('series_user')->where('user_id', $box_id)->update(array('active' => 0));
        DB::table('comic_user')->where('user_id', $box_id)->update(array('active' => 0));
    }

    /*
     * Process the change of password
    */
    public function changePassword()
    {
        $id = Input::get('id');
        $user = User::find($id);
        $old_password = Input::get('old_pass');
        $messages = array();
        if (!Hash::check($old_password, $user->password)) {
            $message = 'la password attuale non è corretta';
            $errors = array('old_pass' => $message);
            return Redirect::to('profile')->withErrors($errors);
        }
        $rules = array('pass' => 'required|min:8|confirmed');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
//            echo $messages;
			return Redirect::to('profile')->withErrors($validator);
        }
        $pass = Input::get('pass');
        $new_hash = Hash::make($pass);
        $user->password = $new_hash;
		$user -> update();
		return Redirect::to('profile');
    }

    /*
     * Displays the box managment page
     */
    public function manageBox($box_id)
    {
        $user = User::find($box_id);
        $series = SeriesUser::where('user_id', '=', $box_id)->get();
        $comics = ComicUser::whereRaw('state_id < 3 and active = 1 and user_id = ' . $box_id)->get();
        $due = $this->due($user);
        if ($user != null)
            $this->layout->content = View::make('admin/viewBox', array('user' => $user, 'comics' => $comics, 'due' => $due, 'series' => $series));
        else
            return Redirect::to('boxes');
    }

    public function buildAvailableArray($boxes)
    {
        $available = null;
        foreach ($boxes as $box) {
            // check available comics and due
            $comics = $box->listComics()->whereRaw('state_id < 3')->get();
            $available_counter = 0;
            foreach ($comics as $comic) {
                if ($comic->comic->available > 1) {
                    $available_counter++;
                }
            }
            $available = array_add($available, $box->id, $available_counter);
        }
        return $available;
    }

    public function buildDueArray($boxes)
    {
        $due = null;
        foreach ($boxes as $box) {
            // check available comics and due
            $comics = $box->listComics()->whereRaw('state_id < 3')->get();
            $due_counter = 0;
            foreach ($comics as $comic) {
                if ($comic->comic->available > 1) {
                    $due_counter += round($comic->price, 2);
                }
            }
            $due_counter = $due_counter - ($due_counter * $box->discount / 100);
            $due = array_add($due, $box->id, $due_counter);
        }
        return $due;
    }

    public function due($user)
    {
        $due = 0;
        $discount = $user->discount;
        foreach ($user->listComics()->whereRaw('state_id < 3 and active = 1')->get() as $comic) {
            if ($comic->comic->available > 1)
                $due += round($comic->price, 2);
        }
        return $due - ($due * $discount / 100);
    }

}

?>