<div class="row carousel-holder">
    <div class="col-md-12">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($slider as $k => $sl)
                <li data-target="#carousel-example-generic" data-slide-to="{{$k}}" class="<?php echo $k==0?'active':'';?>"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($slider as $k => $sl)
                <div class="item <?php echo $k==0?'active':'';?>">
                    <img class="slide-image" src="upload/slide/{{$sl->Hinh}}" alt="">
                </div>
                @endforeach
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>
</div>
