<style>
*{
    margin:0;
    padding:0;
    font-family: sans-serif;
}
.campaign-banner{
    background-image: url('../public/front-assets/images/out-of-home-banner.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
    min-height: 100%;
    position: relative;
}
.logo{
    position: absolute;
    z-index: 10;
    top: 55px;
    right: 85px;
}
.banner-footer h1{
    position: absolute;
    top: 80%;
    background: linear-gradient(0deg, rgba(2,0,36,1) 0%, rgba(29,77,117,1) 82%, rgba(0,212,255,0) 100%);
    color: #fff;
    font-family: sans-serif;
    font-size: 52px;
    text-align: center;
    width: 100%;
    padding: 70px 0 45px 0;
}
.sample-visualization{
    background: linear-gradient(-90deg, rgba(2,0,36,1) 0%, rgba(29,77,117,1) 63%, rgba(0,212,255,0.2945553221288515) 100%);
    min-height:100%;
}
.touchpoint-panel{
    background: #1d4d75;
}
.touchpoint-panel img{
    min-width: calc(100% - 285px);
}
.touchpoint-content{
    display: flex;
}
.touchpoint-count{
    background: #a3ceed;
    height: 50px;
    width: calc(100% - 285px);
}
.touchpoint-content-right{
  padding: 10px 20px 0 20px;
}
.touchpoint-content-right h4{
    text-transform: uppercase;
    font-size: 35px;
    color: #fff;
    font-weight: 500;
}
.touchpoint-content-right p{
    color: #fff;
}
.touchpoint-content-right h5{
    text-transform: uppercase;
    margin: 10px 0 10px;
    font-size: 22px;
    color: #a3ceed;
}
.touchpoint-count{
    background: #a3ceed;
    width: calc(100% - 307px);
    padding: 12px 2px 35px 20px;
    line-height: 1.5;
}
.touchpoint-count h3{
    font-size: 30px;
    color: #1d4d75;
    font-weight: 100;
}
.thanks-panel .touchpoint-one{
    width: 100%;
}
.thanks-panel .touchpoint-two{
    width: 100%;
}
.thanks-panel table{
    min-width:100%;
    border:none;
    border-collapse: collapse;
}
.thanks-panel table td, th{
    border: none;
}
.thanks-panel table td span {
    display: inline-block;
    background: #fff;
    width: 212px;
    height: 20px;
    border-radius: 25px;
    margin: 23px 0 0;
} 
</style>

<section class="campaign-generate-panel">
    <div class="campaign-header">
        <div class="campaign-banner">
            <img class="logo" src="..\public\front-assets\images\mantaray_logo.png" alt="logo" /> 
            <span class="banner-footer">
                <h1>OUT-OF-HOME<br>PROPOSAL</h1>
            </div>
        </div>
    </div>
    <div class="sample-visualization">
        
    </div>
    <div class="touchpoint-panel">
        <div class="touchpoint-content">
            <img class="touchpoint" src="..\public\front-assets\images\touchpoint.png" alt="touch-image" /> 
            <div class="touchpoint-content-right">
                <h4>mumbai</h4>
                <h4>maharastra</h4>
                
                <h5>Location:</h5>
                <p>Jadavpurr Sukanta Setu Xing fac
                Santoshpur Bridge</p>
                
                <h5>Size:</h5>
                <p>50ft x 20ft x 1 Uni</p>
                
                <h5>Illumination:</h5>
                <p>Frontit</p>

                <h5>Format</h5>
                <p>Billboard</p>

                <h5>Traffic Count</h5>
                <p>234569 (Daily)</p>

                <h5>Impression</h5>
                <p>100000</p>
            </div>
        </div>
        
        <div class="touchpoint-count">
            <h3>Touchpoint Count</h3>
            <p>Put touchpoint count here with names</p>
        </div>
    </div>
    <div class="thanks-panel">
        <table>
            <tr>
                <td style="width: 30%;">
                    <img class="touchpoint-one" src="..\public\front-assets\images\building_left.png" alt="touch-image" /> 
                </td>
                <td style="width: 40%; text-align: center; background: #1d4d75;">
                    <h5 style="color:#fff; font-size:45px;">Thanks for<br/>Watching</h5>
                    <span></span>
                </td>
                <td style="width: 30%;">
                    <img class="touchpoint-two" src="..\public\front-assets\images\building_right.png" alt="touch-image" /> 
                </td>
            <tr>
        </table>
    </div>
</section>