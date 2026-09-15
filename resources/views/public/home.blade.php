@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="container flex flex-col gap-15">
<section class="new-relise-music flex flex-col gap-10">
        <h2 class="text-4xl">Новые релизы игр</h2>
        <div class="cards flex justify-between items-center overflow-hidden">
            
        </div>
</section>
<section class="popular-playlists flex flex-col gap-10">
        <h2 class="text-4xl">Популярные плейлисты игровой музыки</h2>
        <div class="playlists flex justify-between items-center">
           
        </div>
</section>
<section class="author-music">
        <h2 class="text-4xl">Популярные авторы игровой музыки</h2>
        <div class="authors flex justify-between ">
            
        </div>
</section>
<section class="music-lists">
        <h2 class="text-4xl">Треки, которые стоит послушать</h2>
        <div class="grid-cols-3 grid">
            
        </div>
</section>
</div>
@endsection
