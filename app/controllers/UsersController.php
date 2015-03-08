<?php
class UsersController extends BaseController
{

    public function create()
    {
        $new = Input::all();
        $user = new User;
        if ($user->validate($new)) {
            $user->username = Input::get('username');
            $user->password = Hash::make(Input::get('password'));
            $user->name = Input::get('name');
            $user->surname = Input::get('surname');
            $user->number = Input::get('number');
            $user->discount = Input::get('discount');
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
        if ($user->validate($new)) {
            $user->name = Input::get('name');
            $user->surname = Input::get('surname');
            $user->number = Input::get('number');
            $new_password = Input::get('newpassword');
            $user->notes = Input::get('notes');
            $new_hash = Hash::make($new_password);
            echo $new_password;
            if ($new_hash != $user->password && $new_password != null) {
                $user->password = $new_hash;
            }
            if(Input::get('show_price')!= $user->show_price)
                $user->show_price = Input::get('show_price');
            $user->discount = Input::get('discount');
            $new_username = Input::get('newusername');
            if($user->username !=  $new_username && $new_username != null){
                $rules = array('newusername' => 'required|email|unique:bm_users,username');
                $validator = Validator::make(Input::all(), $rules);
                $user->username = $new_username;
                if ($validator->fails()) {
                    $errors = $user->errors();
                    return Redirect::to('boxes/' . $id)->withErrors($validator);
                }
            }
            $user->update();
            return Redirect::to('boxes/' . $id);
        } else {
            $errors = $user->errors();
            return Redirect::to('boxes/' . $id)->withErrors($errors);
        }
    }

    public function editNote()
    {
        $new = Input::all();
        $id = Input::get('id');
        $user = User::find($id);

        $rules = array('notes' => 'regex:/^[A-z 0-9àèéìòù&\',\.\?\!()\$\€%"£^\@\;\:\r\n\+\-]*$/');
        $validator = Validator::make(Input::all(), $rules);
        if (!$validator->fails()) {
            $user->notes = Input::get('notes');
            $user->update();
            return Redirect::to('boxes/' . $id);
        } else {
            return Redirect::to('boxes/' . $id)->withErrors($validator);
        }
    }

    public function delete()
    {
        $box_id = Input::get('id');
        $user = User::find($box_id);
        $rules = array('id' => 'required|numeric|exists:bm_users,id,active,1');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('boxes/' . $user->id)->withErrors($validator);
        } else{
            $user->active = 0;
            $user->update();
            DB::table('bm_series_user')->where('user_id', $box_id)->update(array('active' => 0));
            DB::table('bm_comic_user')->where('user_id', $box_id)->update(array('active' => 0));
            return Redirect::to('boxes/' . $user->id);
        }
    }

    public function restore(){
        $box_id = Input::get('id');
        $user = User::find($box_id);
        $rules = array('id' => 'required|numeric|exists:bm_users,id,active,0');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('boxes/' . $user->id)->withErrors($validator);
        } else{
            $user->active = 1;
            $user->update();
            return Redirect::to('boxes/' . $user->id);
        }
    }

    /*
     * Process the change of password
    */
    public function changePassword()
    {
        $id = Input::get('id');
        $user = User::find($id);
        $old_password = Input::get('old_pass');
        if (!Hash::check($old_password, $user->password)) {
            $message = 'La password attuale inserita non è corretta.';
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
 * Process the renewal of the shop card of the box
*/
    public function renewCard()
    {
        $id = Input::get('id');
        $user = User::find($id);
        $shop_card_duration = ShopConf::find(5)->value;
        $old_validity = $user->shop_card_validity;
        $user->shop_card_validity = date('Y-m-d H:i:s',strtotime($old_validity . ' + ' . $shop_card_duration . ' month'));
        $user->update();
        return Redirect::to('boxes/' . $user->id);
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
                if ($comic->comic->available > 0) {
                    $available_counter++;
                }
            }
            $available = array_add($available, $box->id, $available_counter);
        }
        return $available;
    }

    public function buildDueArray($boxes)
    {
        $inv_state = $this -> module_state('inventory');
        $due = null;
        foreach ($boxes as $box) {
            // check available comics and due
            $comics = $box->listComics()->whereRaw('state_id < 3')->get();
            $due_counter = 0;
            foreach ($comics as $comic) {
                if($comic->comic->state == 2) {
                    if (($comic->comic->available > 0 && $inv_state) || (!$inv_state && $comic->comic->state == 2))
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
        $inv_state = $this -> module_state('inventory');
        $due = 0;
        $discount = $user->discount;
        foreach ($user->listComics()->whereRaw('state_id < 3 and active = 1')->get() as $comic) {
            if($comic->comic->state == 2) {
                if (($comic->comic->available > 0 && $inv_state) || (!$inv_state && $comic->comic->state == 2))
                    $due += round($comic->price, 2);
            }
        }
        return $due - ($due * $discount / 100);
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