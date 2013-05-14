<div style="text-align: left;">
    <div style="font-weight: bold;font-size: 14px;">JADWAL PENGAWAS UN<br>SMP NEGERI 1 SUBANG<br>TAHUN PELAJARAN 2012/2013</div>
    <div>
        <?php
        echo Src::image('maps.png', null, array('style' => 'width:800px;height:500px;'));
        ?>        
    </div>
</div>

<div class="ballon-tips ballon-bg-second" showorder="1" style="top: 20px;left: 300px;">
    <div class="baloon-frame" style="margin-top: 80px;">
        <div class="baloon-title">Ruangan 1 :</div>
        <div class="baloon-content">
            <ol>
                <li>Warman Suganda</li> 
                <li>Risnandar</li> 
            </ol>
        </div>
    </div>
</div>

<div class="ballon-tips" showorder="2" style="top: 250px;left: 520px;display: none;">
    <div class="baloon-frame">
        <div class="baloon-title">Ruangan 2 :</div>
        <div class="baloon-content">
            <ol>
                <li>Asep Wahyudin</li> 
                <li>Rahadian Kusuma</li> 
            </ol>
        </div>
    </div>
</div>

<div class="ballon-tips" showorder="3" style="top: 250px;left: 460px;display: none;">
    <div class="baloon-frame">
        <div class="baloon-title">Ruangan 3 :</div>
        <div class="baloon-content">
            <ol>
                <li>Ema Nurmala</li> 
                <li>Rina Gunawan</li> 
            </ol>
        </div>
    </div>
</div>

<div class="ballon-tips" showorder="4" style="top: 250px;left: 395px;display: none;">
    <div class="baloon-frame">
        <div class="baloon-title">Ruangan 4 :</div>
        <div class="baloon-content">
            <ol>
                <li>Ema Nurmala</li> 
                <li>Rina Gunawan</li> 
            </ol>
        </div>
    </div>
</div>

<div class="ballon-tips" showorder="5" style="top: 250px;left: 275px;display: none;">
    <div class="baloon-frame">
        <div class="baloon-title">Ruangan 5 :</div>
        <div class="baloon-content">
            <ol>
                <li>Ema Nurmala</li> 
                <li>Rina Gunawan</li> 
            </ol>
        </div>
    </div>
</div>

<div class="ballon-tips" showorder="6" style="top: 250px;left: 365px;display: none;">
    <div class="baloon-frame">
        <div class="baloon-title">Ruangan 6 :</div>
        <div class="baloon-content">
            <ol>
                <li>Ema Nurmala</li> 
                <li>Rina Gunawan</li> 
            </ol>
        </div>
    </div>
</div>

<div class="ballon-tips" showorder="7" style="top: 250px;left: 430px;display: none;">
    <div class="baloon-frame">
        <div class="baloon-title">Ruangan 7 :</div>
        <div class="baloon-content">
            <ol>
                <li>Ema Nurmala</li> 
                <li>Rina Gunawan</li> 
            </ol>
        </div>
    </div>
</div>

<div class="ballon-tips" showorder="8" style="top: 250px;left: 500px;display: none;">
    <div class="baloon-frame">
        <div class="baloon-title">Ruangan 8 :</div>
        <div class="baloon-content">
            <ol>
                <li>Ema Nurmala</li> 
                <li>Rina Gunawan</li> 
            </ol>
        </div>
    </div>
</div>

<div class="ballon-tips" showorder="9" style="top: 315px;left: 430px;display: none;">
    <div class="baloon-frame">
        <div class="baloon-title">Ruangan 9 :</div>
        <div class="baloon-content">
            <ol>
                <li>Warman Suganda</li> 
                <li>Risnandar</li> 
            </ol>
        </div>
    </div>
</div>

<div class="ballon-tips" showorder="10" style="top: 315px;left: 430px;">
    <div class="baloon-frame">
        <div class="baloon-title">Ruangan 10 :</div>
        <div class="baloon-content">
            <ol>
                <li>Warman Suganda</li> 
                <li>Risnandar</li> 
            </ol>
        </div>
    </div>
</div>
<script>
    $(function(){
    
        var idx = 1;
        var room = 6;
        var timeLeft = 10;
    
        var ballon = function() {
            timeLeft -= 1;
            
            var old_idx = idx;
            idx++;
            
            console.log(idx);
        
            var i, o;
        
            if (idx > room) {
                idx = 1;
            } 
            
            i = idx;
            o = old_idx;
        
            $('div[class=ballon-tips][showorder=' + o + ']').fadeOut('slow',function(){
                $('div[class=ballon-tips][showorder=' + i + ']').fadeIn('slow')
            });
                
            if (true) {
                setTimeout(ballon,5000);
            }
        };
    
        setTimeout(ballon,5000);
    
    });
</script>