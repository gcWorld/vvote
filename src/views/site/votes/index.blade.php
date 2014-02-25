@if(!Vvote::question()=="")
<h4>{{Vvote::question()}}</h4>
<div id="voting">
    <form method="post" action="{{ URL::to('vote/submit') }}">
    <ul class="list-group">
        {{Vvote::answers()}}
    </ul>
    <button type="submit" id="btn-vote" class="btn btn-success btn-vote">Vote!</button>
    <span class="btn btn-primary dropdown-results btn-results" id="btn-results" data-for=".results">View Results</span>
    </form>
</div>

<div id="results">
    {{Vvote::displayResult()}}
<span class="btn btn-primary dropdown-results btn-results" id="show_vote">Abstimmen</span>
</div>
@else
{{ Lang::get('vvote::general.no_vote') }}
@endif