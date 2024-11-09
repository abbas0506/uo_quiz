@extends('layouts.basic')

@section('header')
<x-headers.user page="New Paper" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.user page='paper'></x-sidebars.user>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <a href="{{ route('user.papers.show', $paper) }}">Paper</a>
                <div>/</div>
                <div>Extend Q.</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-2">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="grid md:grid-cols-2 items-end gap-4">
                <div class="flex flex-col md:flex-row gap-3 items-center md:items-end">
                    <img src="{{url('images/icons/add-q.png')}}" alt="paper" class="w-12">
                    <div class="flex flex-col">
                        <h3>{{ $paper->book->name }} </h3>
                        <p>{{$paper->title}}</p>
                    </div>
                </div>
                <div class="text-center md:text-right md:pr-5"><label>Dated: {{ $paper->paper_date->format('d/m/Y') }}</label></div>
            </div>

        </div>

        <div class="divider my-3"></div>

        <div class="grid gap-6 md:w-3/4 mx-auto mt-6">
            <h2 class="text-lg">Question Extension</h2>
            <form id='data-form' action="{{ route('user.paper-question.type.extensions.store', [$paperQuestion, $typeId]) }}" method="post">
                @csrf
                <input type="hidden" name="chapter_id" id='chapter_id' value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="w-3/4">
                        <label>Importance Level</label>
                        <select name="frequency" id="" class="custom-input-borderless text-sm">
                            <option value="1">Normal</option>
                            <option value="2">High</option>
                            <option value="3">Very High</option>
                        </select>
                    </div>

                    <div class="w-3/4 @if($paperQuestion->type_name!='simple-and') hidden @endif" id='marks'>
                        <label>Marks</label>
                        <select name="marks" id="marks" class="custom-input-borderless text-sm">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5" selected>5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>
                @if($paperQuestion->type_name=='simple')
                <h2 class="font-normal text-base mt-8">Please choose an extension style</h2>
                <div class="grid md:grid-cols-2 gap-6 mt-3">
                    <!-- choice 1  -->
                    <div class="grid gap-2 choice active">
                        <h3 class=""><input type="checkbox" id='simple-or' name="type_name" value="simple-or" class="chk mr-2" checked>OR Style <span class="text-xs font-normal">( Optional Parts )</span></h3>
                        <div class="divider border-slate-400"></div>
                        <div class="">
                            <p>Define radius of cricle <span class="font-semibold text-black underline underline-offset-2 ml-2">OR</span></p>
                            <p>Calculate the square root of 36</p>
                        </div>
                    </div>
                    <!-- choice 2 -->
                    <div class="grid gap-2 choice">
                        <h3><input type="checkbox" id='simple-and' name="type_name" value="simple-and" class="chk mr-2"> AND Style <span class="text-xs font-normal">( Mendatory Parts )</span> </h3>
                        <div class="divider border-slate-400"></div>
                        <div>
                            <p>a) Define radius of cricle </p>
                            <p>b) Calculate the square root of 36 </p>
                        </div>
                    </div>
                </div>
                @else
                <input type="text" name="type_name" value="{{ $paperQuestion->type_name }}" hidden>
                @endif
            </form>

            <!-- Chapters List -->
            <div class="grid">
                <p class="mb-3 relative p-2 bg-gradient-to-r from-teal-300 to-teal-100">Please click on any of the following chapters to insert Q.</p>
                @foreach($chapters->sortBy('sr') as $chapter)
                <div data-val='{{$chapter->id}}' class="manual-form-submition text-sm even:bg-slate-100  text-slate-800 p-3 hover:cursor-pointer w-full text-left">{{ $chapter->sr}}. &nbsp {{ $chapter->title }} </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="module">
    $(document).ready(function() {

        $('.manual-form-submition').click(function() {
            $('#chapter_id').val($(this).attr('data-val'))
            $('form').submit();
        })

        $('.choice').click(function() {
            $('.chk').not($(this).children().find('.chk')).prop('checked', false)
            $(this).children().find('.chk').prop('checked', true);

            $(this).addClass('active')
            $('.choice').not(this).removeClass('active')

            if ($(this).children().find('.chk').attr('id') == 'simple-and')
                $('#marks').show();
            else
                $('#marks').hide();
        });

    });
</script>
@endsection