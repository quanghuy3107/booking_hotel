<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/home.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <div class="top">
            <h2 class="title">THK Holdings Vietnamは、意見を共有し、学び合い、成長していける職場環境です。</h2>
            <p class="description">
                当社は2009年に日本で設立され、Web統合サービスを通じて高品質なWebアプリケーションを提供してまいりました。これまで、国内外の数多くのプロジェクトにおいて、革新的で画期的なソリューションおよび高品質なサービスを提供してきました。

                このたび、当社はベトナムにソフトウェア開発拠点を設立したことをご報告いたします。ベトナムは、急速な経済成長、高い技術力、そして勤勉な労働力により、世界的に注目を集めている国です。

                当社がベトナムを選択した理由は、皆様の技術力および人材が、当社の企業理念および将来ビジョンと高い親和性を持っているためです。今回の拠点設立により、コストの最適化、優秀な人材の確保、ならびにグローバル競争力の強化を実現できると考えております。

                ベトナム拠点の開設は、当社の持続的成長戦略の一環であり、将来の発展に向けた重要なステップです。今後、現地の皆様と協力し、ともに成長していけることを心より願っております。
            </p>
        </div>
    </div>



@endsection
