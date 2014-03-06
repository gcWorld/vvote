<?php

class VvoteController extends BaseController {

	/**
	 * Vvote Repository
	 *
	 * @var Vvote
	 */
	protected $vvote;

	public function __construct(Vvote $vvote)
	{
		$this->vvote = $vvote;
	}

    public function getIndex() 
    {
        //$questions = DB::table('vquestions')->get(); 
        $questions = Vvote::All();
        
        return View::make('vvote::admin/votes/index', compact('questions'));
    }
    
    public function getCreate()
	{
        $title ="Create";
        $mode ="create";
		//show the new msg form
		return View::make('vvote::admin/votes/create',compact('title','mode'));

	}
    
    public function postCreate()
    {
        $rules = array(
            'question'   => 'required|min:2',
            'answer1' => 'required|min:2',
            'answer2' => 'required|min:2'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {

			//$user = ConfideRepository->getUserByIdentity( Input::get('to'), $identityColumns = array('username') );
			//$user = User::where('username', '=', Input::get('to'))->first()->get();
			/*$question = Input::get('question');
            $date = Input::get('date');
			$id = DB::table('vquestions')->insertGetId(
                array('name' => $question, 'end' => $date, 'created_at' => time() )
            );*/
            $vote= new Vvote;
            
            $vote->name=Input::get('question');
            $vote->end=Input::get('date');
            //$vote->state=Input::get('status');
            
            $vote->save();
            
            $id = $vote->id;
            
            
            $answers=true;
            $i=1;
            while($answers) {
                $answer=Input::get('answer'.$i);
                $i++;
                if($answer=="") {
                    $answers=false;
                } else {
                    DB::table('vanswers')->insert(
                        array('question' => $id, 'answer' => $answer)
                    );
                }
            }

			return View::make('vvote::admin/votes/modal', compact('title'))->with('success', Lang::get('admin/ticketpacks/messages.create.success'));
		} else {
			return Redirect::action('VvoteController@getCreate')->withErrors($validator)->withInput();
		}   
    }
    
    public function getEdit($vote)
	{
        $title ="Edit";
        $mode ="edit";
		//show the new msg form
		return View::make('vvote::admin/votes/create',compact('title','mode','vote'));

	}
    
    public function postEdit($vote)
    {

        // Validate the inputs
        $validator = Validator::make(Input::all(), Vvote::$rules);

        // Check if the form validates with success
        if ($validator->passes())
        {

			//$user = ConfideRepository->getUserByIdentity( Input::get('to'), $identityColumns = array('username') );
			//$user = User::where('username', '=', Input::get('to'))->first()->get();
			/*$question = Input::get('question');
            $date = Input::get('date');
			$id = DB::table('vquestions')->insertGetId(
                array('name' => $question, 'end' => $date, 'created_at' => time() )
            );*/
            $vote->name=Input::get('question');
            $vote->end=Input::get('date');
            $vote->state=Input::get('status');
            
            $vote->update();
        
			$title = Lang::get('admin/maps/title.create_a_new_map');

			$title = Lang::get('admin/maps/title.create_a_new_map');

			return View::make('vvote::admin/votes/modal', compact('title'))->with('success', Lang::get('admin/ticketpacks/messages.create.success'));
		}

		Redirect::to('admin/vote/' . $vote->id . '/edit')
			->withInput()
			->withErrors($validator)
			->with('message', 'There were validation errors.');
    }
    
    public function postDelete()
	{

		// handle delete confirmation
		$id = Input::get('vote');
		$vote = Vvote::findOrFail($id);
		$vote->delete();
        
        DB::table('vanswers')->where('question', '=', $id)->delete();
        DB::table('vvotes')->where('question', '=', $id)->delete();

		return Redirect::action('VvoteController@getIndex');
	}
    
    public function postVote()
    {
        $question = Vvote::where('state','=','3')->orderBy('created_at','desc')->first();
        $id = $question->id;
        
        $answer = Input::get('voting');
        
        DB::table('vvotes')->insert(
            array('question' => $id, 'answer' => $answer, 'user_id' => Auth::user()->id)
        );
        return Redirect::back();
    }
    
    public function getResults($vote)
    {
        $id = $vote->id;
        $title ="Results";

        $as = DB::table('vanswers')->where('question','=',$id)->get();
        $num = count($as);
        $totalvotes = count(DB::table('vvotes')->where('question','=',$id)->get());
        $results="";
        
        foreach($as as $a){
            $vote = DB::table('vvotes')->where('question','=',$id)->where('answer','=',$a->id)->get();
            $votes2 = count($vote);
            if($totalvotes>0) {
                $votes = $votes2/$totalvotes*100;
            } else {
                $votes = 0;   
            }
            $results.= $a->answer.'<div class="progress"><span class="bar-text">'.$votes.'% ('.$votes2.')</span><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="'.$votes.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$votes.'%"><span class="sr-only">'.$votes.'% '.$a->answer.'</span></div></div>';
        }
        
        
		//show the new msg form
		return View::make('vvote::admin/votes/results',compact('title','id','results'));
    }
}