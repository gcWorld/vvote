vvote
=====

Voting module for Laravel 4

Usage
====

´´´´

    @include('vvote::site.votes.index')


  	<script type="text/javascript">
         $('#results').hide();
         $( ".btn-results" ).click(function() {
                $('#results').toggle();
                 $('#voting').toggle();
        });
         
         @if(Vvote::hasVoted())
             $('#results').show();
             $('#voting').hide();
             $('#show_vote').hide();
         @endif
    </script>
 ´´´´
