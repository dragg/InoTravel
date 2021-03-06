@extends('layout')

@section('content')
<section class="content-wrapper">
    <div class="content">
        <div class="request">

            <!-- request-cont -->
            <div class="profile-default" style="display: <?= $isEmpty === TRUE ? 'block' : 'none' ?>">
                <p>Вы ещё не создали ни одного профиля жилья</p>
                <div class="profile-default-btns-bar">
                    <a href="<?= action('ProfileController@getCreateHabitation')?>" class="btn--profile-default __btn-green">Создать</a>
                </div>
            </div>
            <!-- /request-cont -->
            
            
            
            <!-- request-head -->
            <div class="request-head" style="display: <?= $isEmpty !== TRUE ? 'block' : 'none' ?>">
                <div class="request-head-links">
                    <a href="#" class="request-housing {{ (isset($showRequest) ? ('') : ('__active'))}}"><em>Мое жилье</em></a>
                    <a href="#" class="request-housing  {{ (isset($showRequest) ? ('__active') : (''))}} "><em>Заявки на жилье</em> <span id="tabCountRequests" style="display: {{$countRequests === 0 ? 'none' : 'auto'}}">+{{$countRequests}}</span></a>
                </div>
                <div class="request-head-info clearfix">

                <p style="display: {{$countRequests === 0 ? 'none' : 'block'}}">У Вас <span id="noteCountRequests">{{ $countRequests }}</span> заявки</p>
                <div class="request-head-check " style="display: {{ (isset($showRequest) ? ('auto') : ('none'))}}">
                        <input id="requestHeadCheck" type="checkbox">
                        <label for="requestHeadCheck">Не показывать завершенные</label>
                    </div>
                </div>
            </div>
            <!-- /request-head -->

            <?php if($isEmpty !== TRUE) : ?>
            
            <!-- request-cont -->
            <div class="request-cont" id="my_habitation" style="display: {{ (isset($showRequest) ? ('none') : ('block'))}}" data-active="{{ (isset($showRequest) ? ('false') : ('true'))}}">
                <div class="profile-default" style="margin-top: -60px;float: right;">
                    <div class="profile-default-btns-bar">
                        <a href="{{ action('ProfileController@getCreateHabitation') }}" class="btn--profile-default __btn-green">Добавить</a>
                    </div>
                </div>
                <?php foreach ($habitations as $habitation): ?>
                
                 <!-- quest-block -->
                <div class="quest-block __active clearfix habitation">
                    <div class="page-controls-wr">
                        <a href="{{ action('ProfileController@getCreateHabitation')  . '?id=' . $habitation->id}} " class="page-conrol __write"></a>
                        <a id="{{$habitation->id}}" href="#" class="page-conrol __close delete"></a>
                    </div>
                    <div class="quest-block-img search-load-img">
                        <img src="{{ $habitation->getPathPic() }}" alt="">
                    </div>
                    <div class="quest-block-body">
                        <h4><a href="{{ action('HabitationController@getShowHabitation', $habitation->id)}}">{{$habitation->title}}</a></h4>
                        <div class="quest-block-name">
                            <p class="text-after-icon">
                                <span class="icon-small-wr">
                                    <i class="icon-small __location"></i>
                                </span>
                                {{ $habitation->city->name . " " . $habitation->address }}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /quest-block -->
                
                <?php endforeach; ?>
                
                
            </div>
            <!-- /request-cont -->
            
            <?php endif; ?>
            <!-- request-cont -->
            <div class="request-cont" id="request" style="display: {{ isset($showRequest) ? 'block' : 'none'}}">

                @if(isset($requests))
                    @foreach($requests as $request)
                        <!-- quest-block -->
                        <div class="quest-block {{$request->accept === 0 ?  '__active' : '' }} clearfix">
                            <div class="quest-block-img">
                                <img src="<?= file_exists('public/habitationsPic/' . $request->habitation_id . '.jpg') ? '/habitationsPic/' . $request->habitation_id . '.jpg' : '/habitationsPic/none.jpg'?>" alt="">
                            </div>
                            <div class="page-controls-wr" style="display: {{ ($request->accept === 0 ? 'none' : 'block') }}">
                                <a href="{{ action('RequestController@postRevoke')}}" data-id="{{$request->id}}" class="page-conrol __write edit_request"></a>
                            </div>
                            <div class="quest-block-body" style="width: 400px">
                                <h4><a href="{{action('HabitationController@getShowHabitation', $request->habitation_id)}}">{{ $request->habitation->title }}</a></h4>
                                <div class="quest-block-name">
                                    <p class="text-after-icon"><span class="icon-small-wr"><i class="icon-small __name"></i></span>{{ $request->user->getFullName() }}</p>
                                    <p class="text-after-icon"><span class="icon-small-wr"><i class="icon-small __date"></i></span>{{ $request->getPeriod()}}</p>
                                    <p class="text-after-icon"><span class="icon-small-wr"><i class="icon-small __email"></i></span>{{ $request->user->email }}</p>
                                    <p class="text-after-icon"><span class="icon-small-wr"><i class="icon-small __persons"></i></span>{{ $request->count }}</p>
                                    
                                    <p class="text-after-icon answerRequest" style="display: {{$request->accept === 0 ? 'none' : ' auto' }}"><span class="icon-small-wr"><i class="icon-small __info"></i></span>
                                        <span class="text">
                                        @if($request->accept === -1)
                                            Заявка отклонена
                                        @elseif($request->accept === 1)
                                            Заявка одобрена
                                        @endif
                                        </span>
                                    </p>
                                    
                                </div>
                                
                                <div class="quest-block-btns" style="display: {{ ($request->accept === 0 ? 'block' : 'none') }}" id="{{'buttonRequest' . $request->id }}">
                                    {{ Form::open(['url' => action('RequestController@postAccept'), 'method' => 'post', 'id' => 'accept', 'class' => $request->id, 'style' => 'float: left']) }}
                                    {{ Form::hidden('id', $request->id)}}
                                    {{ Form::submit('Принять', ['class' => 'btn--quest-block __btn-green', 'style' => 'margin-left: 0']) }}
                                    {{ Form::close() }}
                                    
                                    {{ Form::open(['url' => action('RequestController@postRefuse'), 'method' => 'post', 'id' => 'refuse', 'class' => $request->id]) }}
                                    {{ Form::hidden('id', $request->id)}}
                                    {{ Form::submit('Отказать', ['class' => 'btn--quest-block __btn-red']) }}
                                    {{ Form::close() }}
                                </div>
                                
                                
                            </div>
                        </div>
                        <!-- /quest-block -->
                    @endforeach
                @endif
                
                <!-- quest-block -->
                <div class="quest-block clearfix" id="example" style="display: none">
                    <div class="quest-block-img">
                        <img src="" alt="">
                    </div>
                    <div class="page-controls-wr" style="display: auto">
                        <a href="{{ action('RequestController@postRevoke')}}" data-id="" class="page-conrol __write edit_request"></a>
                    </div>
                    <div class="quest-block-body" style="width: 400px">
                        <h4><a href="{{action('HabitationController@getShowHabitation')}}"></a></h4>
                        <div class="quest-block-name">
                            <p class="text-after-icon FullName"><span class="icon-small-wr"><i class="icon-small __name"></i></span><span class="FullName"></span></p>
                            <p class="text-after-icon Period"><span class="icon-small-wr"><i class="icon-small __date"></i></span><span class="Period"></span></p>
                            <p class="text-after-icon Email"><span class="icon-small-wr"><i class="icon-small __email"></i></span><span class="Email"></span></p>
                            <p class="text-after-icon Count"><span class="icon-small-wr"><i class="icon-small __persons"></i></span><span class="Count"></span></p>
                            <p class="text-after-icon StatusRequest answerRequest"><span class="icon-small-wr"><i class="icon-small __info"></i></span>
                                <span class="text StatusRequest"></span>
                            </p>

                        </div>

                        <div class="quest-block-btns" id="buttonRequest">
                            {{ Form::open(['url' => action('RequestController@postAccept'), 'method' => 'post', 'id' => 'accept', 'style' => 'float: left']) }}
                            {{ Form::hidden('id', 0)}}
                            {{ Form::submit('Принять', ['class' => 'btn--quest-block __btn-green', 'style' => 'margin-left: 0']) }}
                            {{ Form::close() }}

                            {{ Form::open(['url' => action('RequestController@postRefuse'), 'method' => 'post', 'id' => 'refuse']) }}
                            {{ Form::hidden('id', 0)}}
                            {{ Form::submit('Отказать', ['class' => 'btn--quest-block __btn-red']) }}
                            {{ Form::close() }}
                        </div>


                    </div>
                </div>
                <!-- /quest-block -->
            </div>
            <!-- /request-cont -->
            
            
            
            
        </div>
    </div>
</section>

@include('habitation.popupDeleteHabitation')
<script src="/js/AutoloadMyRequests.js"></script>
@stop