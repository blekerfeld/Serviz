
        
        $('.btOption').click(function(){
            $('.chooser').slideUp();
            $('.dotsc').slideDown();
            $('.btLoad').load('http://localhost/lvesurvey/assistant/default/choose/ajax', {'btChooser': $(this).data('value')}, function(){
                serveCard(); 
            });

        });

        function loadTranslate(){
            $('.assistantLoader').load('http://localhost/lvesurvey/assistant/translate/ajaxLoad', {}, function(){   
                serveCardForce('translation');
            });
        }

        $('.btOptionDefault').click(function(){
            $('.chooser').slideUp();
            $('.dotsc').slideDown();
            $('.assistantLoader').load('http://localhost/lvesurvey/assistant/' + $(this).data('value') + '/ajaxLoad', {}, function(){
                
            });

        });

        function serveCard(){
            $('.btLoad').slideUp();
            $('.bottomCard').hide();
            $('.dotsc').slideDown();
            $('.btLoad').load('http://localhost/lvesurvey/assistant/default/serve/ajax', {}, function(){
                $('.dotsc').slideUp();
                $('.btLoad').slideDown();
                $('.bottomCard').show();
                $('.btCardHelper').hide().attr('style', '').slideDown();
            });
        };

        function serveCardForce(sectionString){
            $('.btLoad').slideUp();
            $('.bottomCard').hide();
            $('.dotsc').slideDown();
            $('.btLoad').load('http://localhost/lvesurvey/assistant/' + sectionString + 'translate/serve/ajax'), {}, function(){
                $('.dotsc').slideUp();
                $('.btLoad').slideDown();
                $('.bottomCard').show();
                $('.btCardHelper').hide().attr('style', '').slideDown();
            });
        };
        