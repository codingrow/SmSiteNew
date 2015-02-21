<?php
use Model\User;
use Sm\Core\Abstraction\IoC;
?>
<?= Sm\html\HTML::inc_js('Plugin')?>

<script>
    //var sam = new SmPhotoSwipe();

        function animate(opts) {

            var start = new Date;

            var id = setInterval(function() {
                var timePassed = new Date - start;
                var progress = timePassed / opts.duration;

                if (progress > 1) progress = .5;

                var delta = opts.delta(progress);
                opts.step(delta);

                if (progress == 1) {
                    clearInterval(id)
                }
            }, opts.delay || 10)

        }

        function move(element, delta, duration) {
            var to = 500;
          //  alert(element.offsetWidth)
            animate({
                delay: 10,
                duration: duration || 1000, // 1 sec by default
                delta: delta,
                step: function(delta) {
                    var newWidth = element.offsetWidth +10*delta;
                    if(newWidth < 10){
                        this.delta = function(p){
                            return p * p;
                        }
                    }else if( newWidth >= element.parentNode.offsetWidth - 10 ) {
                        this.delta = function(p){
                            return Math.pow(p, 2) * ((10 + 1) * p - 10)
                        };
                        this.duration *= 1/2;
                        return;
                    }
                    //document.getElementById('in').value = newWidth
                    element.style.width = newWidth + 'px';
                    //element.offsetWidth = 100;//element.offsetWidth +   10*delta + '%'
                }
            })
        }
        $(function () {
            var sam = new SmPhotoswipe(document.getElementById('test'));
            var elem = document.getElementById('test');
            /*elem.addEventListener('click', function (e) {
                move(elem, function(p){
                    return Math.sin(p * Math.PI/4);
                })
            })*/
        })
</script>
<?php
include BASE_PATH . 'packages/php/parsecsv.lib.php';
$csv = new parseCSV();
$csv->auto(BASE_PATH . 'app/test/test_login.csv');
var_dump($csv->data);
//passthru(SCRIPT_PATH . 'run_test.bat', $sam);
?>
<style>
    #test{
    width: 200px; height: 200px; background: url('http://localhost/SmSiteNew/p/img/pic/user/Samgineer/uKAIy-Xjb67wZ7H8msIvu.png');
        background-position: center;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    #manna{
        overflow: hidden;
        width: 100%;
        background: #fff;
        text-align: center;
    }
</style>
<section id="main" class="main container">
    <div id="primary" class="clearfix clearfix">
        <div id="manna">
            <input id="in" type="text"/>
            <div id="test">
                &nbsp;
            </div>
        </div>

        <article>
            <form action="<?= MAIN_URL . 'user/_update' ?>" method="post" enctype="multipart/form-data">
                <?php
                /** @var User $user */
                    $user = IoC::$session->get('user');
                if($user and $imgs = $user->findImages()):
                    foreach ($imgs as $image  => $information):
                        $information->initUrl();
                ?>
                        <img src="<?= $information->getUrl()?>" alt="<?= $information->getName() ?>"/>
                <?php endforeach;endif;?>

                <button type="submit">button</button>
            </form>
        </article>
    </div>
</section>