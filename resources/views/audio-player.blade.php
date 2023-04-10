<div id="sirvelia-player" style="background: {{ $bg_color }};" class="pb-fixed pb-w-full pb-left-0 pb-right-0 pb-bottom-0 pb-z-[9999] pb-text-white pb-pb-2">
    <audio class="player-audio" id="player-audio" src="{{ $active_song ? $active_song->url : '' }}" preload="metadata"></audio>

    <div class="playlist-wrapper" style="background: {{ $alt_color }}; display: none;">
        <div class="playlist-wrapper-container pb-block pb-relative pb-mx-auto pb-max-w-5xl">
            <a class="remove-all pb-text-white pb-absolute pb-top-[-40px] pb-right-0 pb-h-10 pb-px-4 pb-inline-block" style="background: {{ $alt_color }};" href="#"><?= __('Remove all', 'audio-playlist-for-woocommerce'); ?></a>

            <ul class="player-playlist pb-p-0 pb-list-none pb-m-0 pb-max-h-[150px] pb-overflow-y-auto">
                @if($playlist)
                    @foreach ($playlist as $song)
                        <li class="pb-flex pb-justify-between pb-items-center playlist-item{{ $song->isActive ? ' active' : '' }}">
                            <span class="song-info pb-flex pb-items-center pb-gap-2 pb-border-b pb- pb-border-0 pb-border-b-gray-200">
                                <a class="song pb-text-white hover:pb-gray-200 pb-no-underline" href="{{ $song->url }}">
                                    <span class="song-title">{{ $song->title }}</span>
                                </a>
                                <a href="{{ $song->productUrl }}" class="view-song pb-text-white"><?= __('Go to product', 'audio-playlist-for-woocommerce'); ?></a>
                            </span>
                            <a href="#" title="<?= __('Remove song', 'audio-playlist-for-woocommerce'); ?>" class="remove-song pb-flex pb-text-white hover:pb-gray-200 pb-no-underline">
                                <svg class="pb-text-red-500 pb-w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6"></path>
                                </svg>
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>

    <div class="pb-flex pb-items-center pb-justify-between pb-max-w-screen-2xl pb-mt-2 pb-gap-4 pb-mx-auto line-container">
        <div class="player-buttons pb-flex pb-justify-center pb-items-center">
            <a class="previous-btn pb-flex pb-text-white pb-no-underline hover:pb-text-gray-200 focus:pb-text-gray-200" href="#">
                <svg class="pb-h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953l7.108-4.062A1.125 1.125 0 0121 8.688v8.123zM11.25 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953L9.567 7.71a1.125 1.125 0 011.683.977v8.123z"></path>
                </svg>
            </a>
            <a class="playPause-btn pb-flex pb-text-white pb-no-underline hover:pb-text-gray-200 focus:pb-text-gray-200" href="#">
                <svg class="apw-play-btn pb-h-12 pb-block" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"></path>
                </svg>
                <svg class="apw-pause-btn pb-h-12 pb-hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5"></path>
                </svg>
            </a>
            <a class="next-btn pb-flex pb-text-white pb-no-underline hover:pb-text-gray-200 focus:pb-text-gray-200" href="#">
                <svg class="pb-h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062A1.125 1.125 0 013 16.81V8.688zM12.75 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062a1.125 1.125 0 01-1.683-.977V8.688z"></path>
                </svg>
            </a>
        </div>

        <div class="player-info">
            <div class="info-data pb-flex pb-justify-between pb-items-center">
                <div class="pb-flex pb-gap-2 pb-items-center">
                    <span class="current-song">
                        @if($active_song)
                            {{ $active_song->title }}
                        @else
                            <?= __('No song selected', 'audio-playlist-for-woocommerce'); ?>
                        @endif
                    </span>
                    <span class="current-time">
                        @if ($time_cookie)
                            {{ $getPlaylistTime($time_cookie) }}
                        @endif
                    </span>
                </div>
                @if($active_song)
                    <a class="view-album pb-text-white" href="{{ $active_song->productUrl }}"><?= __('Go to product', 'audio-playlist-for-woocommerce'); ?></a>
                @endif
            </div>

            <div class="pb-flex pb-items-center pb-gap-4">
                <input class="time-range" id="playlist-time-range" type="range" value="0" />

                <div class="volume pb-flex pb-items-center">
                    <input class="time-range" id="playlist-volume-range" type="range" value="100" />
                    <svg class="pb-h-8 pb-w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z"></path>
                    </svg>
                </div>
            </div>
        </div>


        <a class="showHide-btn pb-text-white hover:pb-text-gray-200 focus:pb-no-underline" href="#">
            <?= __('Open Playlist', 'audio-playlist-for-woocommerce'); ?> ▲
        </a>
    </div>

</div>