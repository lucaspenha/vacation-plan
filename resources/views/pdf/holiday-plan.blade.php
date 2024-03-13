<div style="font-family:Arial, Helvetica, sans-serif">
    <h1 class="">2024 - Vacation Plan</h1>

    <br>

    <h3 class="text-[24px] font-bold text-stone-600">{{$data->title}}</h3>
    <p> 
        <span style="color:gray">date</span> {{$data->date}} 
        <span style="margin-left:20px"></span>
        <span style="color:gray">locale</span> {{$data->location}}
    </p>
    <br>
    <h4 class="text-gray-500">description</h4>
    <p class="text-gray-900">{!! nl2br($data->description) !!}</p>

    <p></p>
    @if($data->participants)
    <h4 class="text-gray-500">participants</h4>
    @foreach($data->participants as $participant)
    <p>&bull; {{$participant}}</p>
    @endforeach
    @endif
</div>
