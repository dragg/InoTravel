<?php

class HabitationController extends BaseController {
    
    private function getHabitation($habitation_id) {
        $habitation = DB::table('habitations')
                ->where('id', $habitation_id)
                ->first();
        
        $selectAmenities = DB::table('habitation_amenities')
                    ->where('habitation_id', $habitation_id)
                    ->get();
            
        $selectRestrictions = DB::table('habitation_restrictions')
                ->where('habitation_id', $habitation_id)
                ->get();
        
        $response['habitation'] = $habitation;
        $response['sAm'] = $selectAmenities;
        $response['sRe'] = $selectRestrictions;
        
        return $response;
    }

    public function postSaveHabitation() {
        
        $habitation_id = Input::get('id');
        
        if(isset($habitation_id) && $habitation_id != '') {
            DB::table('habitations')
                    ->where('id', $habitation_id)
                    ->update(['title' => Input::get('name'),
                              'address' => Input::get('address'),
                              'places' => Input::get('sleeper'),
                              'city_id' => Input::get('city'),
                              'description' => Input::get('description')]);
            
                
            DB::table('habitation_amenities')
                ->where('habitation_id', $habitation_id)
                ->delete();
            
            DB::table('habitation_restrictions')
                ->where('habitation_id', $habitation_id)
                ->delete();
            
        } else {
            
            $user = DB::table('users')->where('email', Auth::user()['email'])->first();
            
            $habitation_id = DB::table('habitations')->insertGetId(['user_id' => $user->id,
                'title' => Input::get('name'), 'address' => Input::get('address'),
                'places' => Input::get('sleeper'), 'city_id' => Input::get('city'),
                'description' => Input::get('description')]);
        }
       
        $amenities = Input::get('amentities');
        if(isset($amenities)) {
            foreach ($amenities as $amenity) {
                DB::table('habitation_amenities')->insert([
                    'habitation_id' => $habitation_id,
                    'amenity_id' => $amenity]);
            }
        }
        
        $restrictions = Input::get('restrictions');
        if(isset($restrictions)) {
            foreach ($restrictions as $restriction) {
                DB::table('habitation_restrictions')->insert([
                    'habitation_id' => $habitation_id,
                    'restriction_id' => $restriction]);
            }
        }
        
        return Redirect::action('ProfileController@getMyHabitation');
    }
    
    public function postDeleteHabitation() {
        $response = FALSE;
        
        $id = Input::get('id');
        $habitation = DB::table('habitations')->where('id', $id)->first();
        
        if (isset($habitation)) {
            DB::table('habitations')->where('id', $id)->update(['deleted' => 1]);
            $response = TRUE;
        }
        
        return Response::json($response);
    }
    
    public function getCreateHabitation() {
        
        $amenities = DB::table('amenities')->get();
        $restrictions = DB::table('restrictions')->get();
        $cities = DB::table('cities')->get();
        
        $response = ['amenities' => $amenities, 'restrictions' => $restrictions,
                'cities' => $cities];
        
        $id = Input::get('id');
        
        if(isset($id)) {
//            $habitation = DB::table('habitations')
//                ->where('id', $id)
//                ->first();
//            
//            $selectAmenities = DB::table('habitation_amenities')
//                    ->where('habitation_id', $id)
//                    ->get();
//            
//            $selectRestrictions = DB::table('habitation_restrictions')
//                    ->where('habitation_id', $id)
//                    ->get();
//            
            $res = $this->getHabitation($id);
            $response['habitation'] = $res['habitation'];
            $response['sAm'] = $res['sAm'];
            $response['sRe'] = $res['sRe'];
            
            //var_dump($response);die();
            //array_merge($response, $res);
            
        }
        
        return View::make('profile.create_habitation', $response);
    }
    
    public function getShowHabitation($habitation_id) {
        $params = [];
        
        $habitation = DB::table('habitations')
                ->where('habitations.id', $habitation_id)
                ->join('cities', 'habitations.city_id', '=', 'cities.id')
                ->select('habitations.id', 'title', 'address', 'description', 'places', 'cities.name as city', 'places')
                ->first();
        
        $amenities = DB::table('habitation_amenities')
                ->where('habitation_id', $habitation_id)
                ->join('amenities', 'amenities.id', '=', 'habitation_amenities.amenity_id')
                ->select('name')
                ->get();
        
        $restrictions = DB::table('habitation_restrictions')
                ->where('habitation_id', $habitation_id)
                ->join('restrictions', 'restrictions.id', '=', 'habitation_restrictions.restriction_id')
                ->select('name')
                ->get();
        
        $params['habitation'] = $habitation;
        $params['amenities'] = $amenities;
        $params['restrictions'] = $restrictions;
        
        //var_dump($params); die();
        
        return View::make('habitation.show_habitation', $params);
    }
}
