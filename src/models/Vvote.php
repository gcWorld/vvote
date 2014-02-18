<?php

class Vvote extends Eloquent {
	//protected $guarded = array();
    
    protected $table = 'vquestions';
    
    public static $rules = array(
		'question' => 'required',
	);

    public function getStatus()
    {
        if ($this->state==3) {
        	$status = "<span class='approved'>Aktiv</span>";
        } else{
            $status = "<span class='text-danger'>Inaktiv</span>";
        }
        return HTML::decode($status);
    }
    
    public function getActions()
    {
    	$edit="<a href='". URL::to('admin/vote/'.$this->id.'/edit') ."' class='iframe tooltips' title='". Lang::get('button.edit')."'>".Lang::get('icon.edit')."</a> ";
    	$delete="<a href='#' data-toggle='modal' data-target='#deletevote' data-id='". $this->id ."' class='votedelete-link tooltips' title='". Lang::get('button.delete')."'>". Lang::get('icon.delete') ."</a> ";
        $results='<a href="'. URL::to('admin/vote/'.$this->id.'/results') .'" class="iframe tooltips" title="Results"><i class="icon-bar-chart"></i></a> ';
            $actions = $edit.$delete.$results;
        return HTML::decode($actions);
    }
    
    public function enddate()
    {
        $date = new DateTime($this->end);
        //$date = date_timestamp_get($date[0]);
        $lang = Config::get('application.language'); 
        $formatted = $date->format('d.m.Y');

        return $formatted;
    }
    
    public function question()
    {
        $question = Vvote::where('state','=','3')->orderBy('created_at','desc')->first();
        $return = $question->name;
        return $return;   
    }
    
    public function answers()
    {
        $question = Vvote::where('state','=','3')->orderBy('created_at','desc')->first();
        $id = $question->id;
        $as = DB::table('vanswers')->where('question','=',$id)->get();
        foreach($as as $a) {
            $return.= 
                    "<li class='list-group-item'>
                        <div class='radio'>
                            <label>
                                <input type='radio' name='voting' value='".$a->id."'>
                                ".$a->answer."
                            </label>
                        </div>
                    </li>";
        }
        
        return $return;
    }
    
    public function hasVoted()
    {
        $question = Vvote::where('state','=','3')->orderBy('created_at','desc')->first();
        $id = $question->id;
        $vote = DB::table('vvotes')->where('question','=',$id)->where('user_id','=',Auth::user()->id)->select('user_id')->first();
        
        if(is_null($vote->user_id)){ $return=false; } else { $return=true; }
        return $return;
    }
    
    public function displayResult()
    {
            $question = Vvote::where('state','=','3')->orderBy('created_at','desc')->first();
            $id = $question->id;
        $as = DB::table('vanswers')->where('question','=',$id)->get();
        $num = count($as);
        $totalvotes = count(DB::table('vvotes')->where('question','=',$id)->get());
        
        foreach($as as $a){
            $vote = DB::table('vvotes')->where('question','=',$id)->where('answer','=',$a->id)->get();
            $votes = count($vote);
            $votes = $votes/$totalvotes*100;
            $return.= $a->answer.'<div class="progress"><span class="bar-text">'.$votes.'%</span><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="'.$votes.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$votes.'%"><span class="sr-only">'.$votes.'% '.$a->answer.'</span></div></div>';
        }
        
        return $return;
    }
    
    public static function displayResults($id=0)
    {
        $return=0;
        if($id=0) {
            $question = Vvote::where('state','=','3')->orderBy('created_at','desc')->first();
            $id = $question->id;
        }
        $as = DB::table('vanswers')->where('question','=',$id)->get();
        $num = count($as);
        $totalvotes = count(DB::table('vvotes')->where('question','=',$id)->get());
        
        foreach($as as $a){
            $vote = DB::table('vvotes')->where('question','=',$id)->where('answer','=',$a->id)->get();
            $votes = count($vote);
            $votes = $votes/$totalvotes*100;
            $return.= $a->answer.'<div class="progress"><span class="bar-text">'.$votes.'%</span><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="'.$votes.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$votes.'%"><span class="sr-only">'.$votes.'% '.$a->answer.'</span></div></div>';
        }
        
        return $return;
    }
}