<div class="col-lg-4 mb-3">
    <div class="card">
        <div class="view overlay">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe src="{{ $url }}" frameborder="0" allowfullscreen=""></iframe>
            </div>
            <a>
                <div class="mask rgba-white-slight waves-effect waves-light"></div>
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $title }}</h5>
            <p class="card-text">{{ $description }}</p>
            <a href="{{ $channel }}" target="blank" class="btn btn-danger">Visit YouTube Channel</a>
        </div>
    </div>
</div>