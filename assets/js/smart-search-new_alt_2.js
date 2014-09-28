//<?php echo $this->partial('header_responsive.phtml'); ?>
<div class="page-wrapper">
	<div class="page-container">
			<!-- blog container start -->
		<?= $this->layout()->content ?>
		<!-- blog container end -->
	</div>

<script  type="text/javascript">

function SMART_SEARCH(input_selector, result_selector, options)
{
//	var input_selector=input_selector;
//	var result_selector=result_selector;

    var return_timestamp=0;
    var active_timestamp=0;
    var timeout_handler;

    var input;
    var result;

    var search_str;
    var query_id;

    //set default values
//	var keyup_time=100; // time after last key up before keyword search is sent (in milliseconds)
// bumping up the time here to try and minimize server and db hits...
    var keyup_time=300; // time after last key up before keyword search is sent (in milliseconds)
    var full_text_time=1000; // time after keyword search is sent before full text search (in milliseconds)
    var stat_track_time=3000; // time after keyword search is sent before search stat is tracked (in milliseconds)

    var hover_results = false;
    var focus_input = false;

    if (options.keyup_time) { keyup_time=options.keyup_time; }
    if (options.full_text_time) { full_text_time=options.full_text_time; }
    if (options.stat_track_time && (options.stat_track_time>full_text_time)) { stat_track_time=options.stat_track_time; } //make sure stats track after full text requests

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////					Smart Search Keyword Hinting		////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    var hint_setInterval = setInterval(ss_hint, options.hint_speed);

    var hint_keyword_count = options.hint_keywords.length;

    var hint_count = 0;
    var curr_hint_letter = 0;
    var curr_hint_word = 0;
    var curr_word_length;
    var hint = true;

    function ss_hint()
    {
        if(focus_input == false && hint == true)
        {
            if(hint_count == 0)
            {
                input.val('');
                curr_hint_word = 0;
                curr_hint_letter = 0;
                curr_word_length = options.hint_keywords[curr_hint_word].length;
            }

            if(curr_hint_letter <= curr_word_length)
            {
                input.val(input.val()+options.hint_keywords[curr_hint_word].charAt(curr_hint_letter));
                curr_hint_letter++;
            }
            else
            {
                //input.val('');
                curr_hint_letter = 0;
                curr_hint_word++;

                if(curr_hint_word == hint_keyword_count)
                {
                    curr_hint_word = 0;
                }

                curr_word_length = options.hint_keywords[curr_hint_word].length;

                clearInterval(hint_setInterval);
                setTimeout(function() { input.val(''); hint_setInterval = setInterval(ss_hint, options.hint_speed);}, options.hint_delay);
            }

            hint_count++;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function init()
    {
        hint_setInterval;

        input=$(input_selector);
        result=$(result_selector);
        if (input.length && (input.val()!=search_str))
        {
            //use keyup or change here???
            input.keyup(function() {
                hint = false;
                if (input.val().length)
                {
                    search_str=input.val();

                    window.clearTimeout(timeout_handler);
                    timeout_handler=window.setTimeout(keyword_search, keyup_time);
                }
                else
                {
                    result.parent().hide();
                    result.hide();
                }
            });
            input.focus(function() {
                hint_count = 0;
                if(hint == true)
                {
                    input.val('');
                }

                focus_input = true;
                if(input.val() != '') {
                    result.parent().slideDown("slow");
                }
            });
            input.blur(function() {
                focus_input = false;
                if(input.val().length == 0)
                {
                    hint = true;
                }
                else
                {
                    hint = false;
                }

                if(hover_results == false)
                {
                    result.parent().slideUp("slow");
                }
            });
        }

        result.hover(
            function() {
                hover_results = true;
            },
            function () {
                hover_results = false;
                if(focus_input == false)
                {
                    result.parent().slideUp("slow");
                }
            }
        );

        result.parent().find('.close-result-wrapper').click(function() {
            result.parent().slideUp("slow");
        });
    }

//    function keyword_search()
//    {
//        window.clearTimeout(timeout_handler);
//        timeout_handler=window.setTimeout(full_text_search, full_text_time);
//
//        $.post("/ajax/private/smart-search/searchinput/keyword_search/1234/", { search:search_str }, result_response, "html");
//    }

//    function full_text_search()
//    {
//        //timeout_handler=window.setTimeout(stat_track, (stat_track_time-full_text_time));
//        $.post("/ajax/private/smart-search/searchinput/full_text_search/1234/", { search:search_str }, result_response, "html");
//    }

//    function stat_track()
//    {
////this will cache results
//    }
//
//    init();
//
//    return {
//
//    };

//    function result_response(response_data)
//    {
//        var split_i=response_data.indexOf('::');
//        return_timestamp=response_data.substring(3, split_i);
//
//        if (return_timestamp > active_timestamp)
//        {
//            new_content=response_data.substr((split_i+2));
//
//            update_result_content(new_content, return_timestamp);
//        }
//    }

//    function update_result_content(new_content)
//    {
//        result.empty();
//        result.html(new_content);
//        result.show();
//        result.parent().show();
//
//
//        active_timestamp=return_timestamp;
//    }
}

//function more_toggle(type)
//{
//    if ($('#more_'+type).hasClass('visible'))
//    {
//        $('#more_'+type).removeClass('visible');
//        $('#more_'+type).slideUp();
//        $('#toggle_more_'+type).html('<img src="http://dashboard.dealereprocess.com/assets/d1/img/icons/add.png" /> show more');
//    }
//    else
//    {
//        $('#more_'+type).addClass('visible');
//        $('#more_'+type).slideDown();
//        $('#toggle_more_'+type).html('show less');
//    }
//}

function search_term_track()
{
    if ($("#q").val().length)
    {
        $.post("/resrc/smart-search/searchinput/", { search_string:$("#q").val() });
    }
}


</script>
    <script type="text/javascript">
        var SS;
        (function() {
            SS=SMART_SEARCH('#q', {"hint_keywords":["New Honda","2014 Gray Accord","Service appointment","Coupons","Used Toyota Camry","Black Civic","Hours","Used Gray Camry","Order Parts","Navigation"],"hint_speed":150,"hint_delay":1000});
        })();
    </script>
//<?php echo $this->partial('footer_responsive.phtml'); ?>