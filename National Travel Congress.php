<?php
// 導入共用的頁首檔案
// 建議確認路徑是否正確
if (file_exists('headfooter/header4.php')) {
    include 'headfooter/header4.php';
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>國旅大會 - 誠訊歷史資料庫 (CX-Wiki)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&family=Noto+Serif+TC:wght@600;700&display=swap" rel="stylesheet">
    <style>
        /* --- 誠訊資料庫樣式表 (基於 Wikipedia Vector 風格重製) --- */
        :root {
            --bg-body: #f8f9fa;
            --bg-content: #ffffff;
            --text-primary: #202122;
            --text-secondary: #54595d;
            --link-color: #3366cc;
            --link-visited: #795cb2;
            --link-hover: #447ff5;
            --border-subtle: #eaecf0;
            --border-strong: #a2a9b1;
            --heading-font: 'Noto Serif TC', 'Linux Libertine', Georgia, serif;
            --body-font: 'Noto Sans TC', sans-serif;
            --toc-bg: #f8f9fa;
        }

        /* 重置與基礎設定 */
        * { box-sizing: border-box; }
        
        body {
            font-family: var(--body-font);
            background-color: var(--bg-body);
            color: var(--text-primary);
            margin: 0;
            line-height: 1.6;
            font-size: 16px;
        }

        /* 佈局 */
        .page-wrapper {
            max-width: 1300px;
            margin: 0 auto;
            background: var(--bg-content);
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        /* 頁面標題區 (模擬 Wiki Header) */
        .wiki-header {
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-strong);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
        }

        .wiki-logo {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .wiki-logo span {
            background: #202122;
            color: #fff;
            padding: 2px 8px;
            border-radius: 2px;
            font-family: var(--heading-font);
        }

        /* 內容網格 */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem;
        }

        @media (min-width: 992px) {
            .content-grid {
                grid-template-columns: minmax(0, 3fr) 320px; /* 內容 : 側邊欄 */
                padding: 2rem 3rem;
            }
        }

        /* 文章樣式 */
        .article-title {
            font-family: var(--heading-font);
            font-size: 2.2rem;
            font-weight: 400;
            border-bottom: 1px solid var(--border-strong);
            padding-bottom: 0.2em;
            margin-top: 0;
            margin-bottom: 0.5em;
        }

        .site-sub {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        /* 警告橫幅 */
        .alert-box {
            border: 1px solid #ffcc00;
            background-color: #fef6e7;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border-left: 5px solid #ffcc00;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-box.archive {
            border-color: #a2a9b1;
            background-color: #f8f9fa;
            border-left-color: #72777d;
            color: var(--text-secondary);
        }

        /* 標題 H2, H3 */
        h2 {
            font-family: var(--heading-font);
            font-weight: 400;
            font-size: 1.7rem;
            border-bottom: 1px solid var(--border-subtle);
            margin-top: 2rem;
            padding-bottom: 0.3rem;
        }

        h3 {
            font-family: var(--body-font);
            font-weight: 700;
            font-size: 1.2rem;
            margin-top: 1.5rem;
        }

        /* 連結 */
        a { color: var(--link-color); text-decoration: none; }
        a:hover { text-decoration: underline; color: var(--link-hover); }

        /* 列表 */
        ul, ol { margin: 0.5rem 0 1rem 2rem; padding: 0; }
        li { margin-bottom: 0.3rem; }

        /* 目錄 TOC */
        .toc {
            background-color: var(--toc-bg);
            border: 1px solid var(--border-strong);
            padding: 1rem;
            display: inline-block;
            min-width: 250px;
            margin: 1rem 0 2rem 0;
            border-radius: 2px;
        }
        
        .toc-title {
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .toc ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .toc li { margin-bottom: 0; }
        
        .toc a {
            display: block;
            padding: 4px 0;
            color: var(--link-color);
            font-size: 0.9rem;
        }
        
        .toc-number { color: var(--text-primary); margin-right: 0.3em; }

        /* 側邊欄 Infobox */
        .infobox {
            border: 1px solid var(--border-strong);
            background-color: #f9f9f9;
            padding: 0.2rem;
            font-size: 0.9rem;
            line-height: 1.4;
            width: 100%;
            margin-bottom: 2rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .infobox-title {
            background-color: #cedff2; /* Wiki 風格藍 */
            padding: 0.5rem;
            text-align: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .infobox-image {
            text-align: center;
            padding: 10px 0;
            background: #fff;
            border-bottom: 1px solid var(--border-subtle);
        }

        .infobox table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .infobox th {
            text-align: left;
            padding: 6px 10px;
            width: 40%;
            vertical-align: top;
            font-weight: bold;
        }

        .infobox td {
            padding: 6px 10px;
            vertical-align: top;
        }
        
        .infobox-status-dead {
            background: #ffebee;
            color: #c62828;
            text-align: center;
            font-weight: bold;
            padding: 4px;
            border-top: 1px solid #ffcdd2;
        }

        /* 參考資料 */
        .references {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        
        .references li { margin-bottom: 0.5rem; }

        /* 腳註 */
        .footer {
            padding: 2rem;
            border-top: 1px solid var(--border-subtle);
            text-align: center;
            font-size: 0.8rem;
            color: var(--text-secondary);
            background: var(--bg-body);
        }

        /* 分類盒 */
        .catlinks {
            border: 1px solid var(--border-strong);
            background-color: #f8f9fa;
            padding: 0.5rem 1rem;
            margin-top: 2rem;
            clear: both;
            font-size: 0.85rem;
        }
        .catlinks a {
            padding: 0 0.5rem;
            border-right: 1px solid var(--border-strong);
        }
        .catlinks a:last-child { border: none; }

        /* 圖片占位符 */
        .placeholder-img {
            width: 150px;
            height: 150px;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: #aaa;
            border: 1px dashed #ccc;
        }

    </style>
</head>
<body>

<div class="page-wrapper">
    <header class="wiki-header">
        <div class="wiki-logo">
            <span>CX</span> 誠訊歷史資料庫
        </div>
        <div style="font-size: 0.9rem; color: #666;">
            登入者：李子杰 (Admin)
        </div>
    </header>

    <div class="content-grid">
        <main>
            <h1 class="article-title">國旅大會</h1>
            <div class="site-sub">維基百科，自由的誠訊歷史百科全書</div>
            
            <div class="alert-box archive">
                <div style="font-size:1.2rem;">🏛️</div>
                <div>
                    <b>本條目已歸檔。</b><br>
                    此組織已於 2023 年停止運作，內容僅供歷史考證參考。
                </div>
            </div>

            <p><b>國家旅遊代表大會</b>（英語：National Travel Congress，縮寫：<b>NTC</b>），簡稱<b>國旅大會</b>、<b>國大</b>，早期非正式名稱為<b>麻將顏值組</b>，是<a href="#">	金融旅遊</a>前身相關組織中，曾在2021年至2023年間運作的最高決策與聯誼機構。</p>
            
            <p>該組織成立於 COVID-19 疫情三級警戒期間，最初作為線上娛樂與社交的臨時團體，後轉型為具備議事規則的決策組織。隨著疫情趨緩及成員生涯規劃改變，大會運作頻率降低，並於 2023 年元旦起實質凍結運作<sup class="reference"><a href="#cite1">[1]</a></sup>。</p>

            

            <section id="history">
                <h2>歷史背景</h2>
                <p>2021年中，台灣爆發新冠肺炎疫情，實施三級警戒，導致多數實體社交活動停擺。在此背景下，創始成員李子杰、陳柏蓁、李映葳、陳品妤與鍾瑜珍五人，於2021年6月2日共同發起成立了該組織的前身。</p>
                <p>初期組織以線上遊戲（如麻將）及視訊交流為主，故早期被稱為「麻將顏值組」或「金融旅遊執行委員會」。隨著組織發展，成員們希望將決策過程制度化，遂參照《中華民國憲法》及孫中山先生的五權憲法理論，建立了獨特的「一院制」議會結構，並正式定名為「國家旅遊代表大會」<sup class="reference"><a href="#cite2">[2]</a></sup>。</p>
            </section>

            <section id="structure">
                <h2>組織架構與職權</h2>
                <p>國旅大會是原金融旅遊體系中的最高權力機關，集立法權與部分行政執行權於一身。其主要職權包括：</p>
                <ul>
                    <li><b>旅遊規劃權</b>：決定團體旅遊的目的地、預算與行程（此為組織核心功能）。</li>
                    <li><b>人事任命權</b>：推選或輪替大會主席。</li>
                    <li><b>法規制定權</b>：修訂《麻將顏值共同綱領》及會議規則。</li>
                </ul>
            </section>

            <section id="rules">
                <h2>運作規則</h2>
                <p>2022年，第一屆正式大會於通訊軟體 Discord 上召開，標誌著組織進入「法制化時期」。</p>

                <h3 id="veto">否決權機制</h3>
                <p>為了確保決策的和諧與共識，大會採取了極為嚴格的表決制度。根據《共同綱領》第三章第12條，任何非程序性的重大決議案，必須滿足以下條件方可通過：</p>
                <ol>
                    <li>至少獲得一名常任理事的明確支持。</li>
                    <li><b>完全無反對票</b>（Unanimous Consent）。</li>
                </ol>
                <p>這意味著任何一名成員皆擁有實質的「一票否決權」，此機制雖保障了少數意見，但也曾在後期導致部分議案議事效率低落<sup class="reference"><a href="#cite3">[3]</a></sup>。</p>

                <h3 id="election">主席任命與輪替</h3>
                <p>大會主席（Speaker）是名義上的最高負責人。根據2022年修訂的章程，其產生方式具有隨機性與趣味性：</p>
                <ul>
                    <li><b>最後抵達制</b>：在特定會議中，由最後登入或抵達會場的代表直接任命下一任主席<sup class="reference"><a href="#cite4">[4]</a></sup>。</li>
                    <li><b>補選機制</b>：若現任主席辭職或無法視事，必須在三分鐘內完成補選。</li>
                    <li><b>連任限制</b>：原則上不得連任兩次，以防止權力過度集中。</li>
                </ul>
            </section>

            <section id="leaders">
                <h2>歷任主席</h2>
                <p>以下為國旅大會活躍期間的歷任主席紀錄（部分代理）：</p>
                <table style="width:100%; text-align:left; border-collapse: collapse; font-size: 0.9rem;" border="1" cellpadding="8">
                    <thead style="background:#f2f2f2;">
                        <tr>
                            <th>任次</th>
                            <th>姓名</th>
                            <th>就任日期 (民國/西元)</th>
                            <th>備註</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>陳品妤</td>
                            <td>111年07月25日 (2022)</td>
                            <td>首屆Discord大會主席</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>張紫儀</td>
                            <td>111年07月28日 (2022)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>代理</td>
                            <td>李映葳</td>
                            <td>111年07月30日 (2022)</td>
                            <td>代理張紫儀主席職務</td>
                        </tr>
                        <tr>
                            <td>代理</td>
                            <td>鍾瑜珍</td>
                            <td>111年08月04日 (2022)</td>
                            <td>代理張紫儀主席職務</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>李子杰</td>
                            <td>112年07月27日 (2023)</td>
                            <td>誠訊工作室創辦人</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>陳柏蓁</td>
                            <td>112年08月19日 (2023)</td>
                            <td>推動議事改革，廢除部分繁瑣規章</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section id="dissolution">
                <h2>組織凍結與後續</h2>
                <p>隨著後疫情時代來臨，成員回歸實體工作與生活（如創辦人李子杰投身百貨與誠訊工作室業務），線上聚會需求大幅減少。2023年8月，在第四任主席陳柏蓁任內完成最後一次重大改革後，組織活動逐漸沉寂。</p>
                <p>目前，國旅大會的相關歷史文件與數據已被移交至「誠訊歷史資料庫」進行數位保存，作為誠訊控股發展史的一部分。</p>
            </section>

            <section id="ref">
                <h2>參考資料</h2>
                <ol class="references">
                    <li id="cite1">國旅大會秘書處。《關於凍結常態性會議之聲明》。誠訊公報，2023年1月。</li>
                    <li id="cite2">李子杰等。《麻將顏值共同綱領》。2021年6月原始文件。</li>
                    <li id="cite3">《國旅大會議事錄 - 第202207號》。</li>
                    <li id="cite4">國旅大會組織章程（2022年修訂版），第四章「人事任命」。</li>
                </ol>
            </section>

            <div class="catlinks">
                <b>分類：</b>
                <a href="#">已解散組織</a>
                <a href="#">2021年建立</a>
                <a href="#">2023年廢止</a>
                <a href="#">集會歷史</a>
                <a href="#">私人決策機構</a>
            </div>

        </main>

        <aside>
            <div class="infobox">
                <div class="infobox-title">國家旅遊代表大會</div>
                <div class="infobox-image">
                    <?php if(file_exists('image/國旅徽章.png')): ?>
                        <img src="image/國旅徽章.png" alt="國旅大會徽章" width="150">
                    <?php else: ?>
                        <div class="placeholder-img">
                            (徽章圖檔缺失)
                        </div>
                    <?php endif; ?>
                    <div style="padding:5px; font-size:0.85rem;">國旅大會識別標誌</div>
                </div>
                
                <div class="infobox-status-dead">已停止運作</div>

                <table>
                    <tr>
                        <th>英文名稱</th>
                        <td>National Travel Congress</td>
                    </tr>
                    <tr>
                        <th>簡稱</th>
                        <td>國大、旅大、NTC</td>
                    </tr>
                    <tr>
                        <th>前身</th>
                        <td>金融旅遊執行委員會<br>麻將顏值組</td>
                    </tr>
                    <tr>
                        <th>成立日期</th>
                        <td>2021年6月2日</td>
                    </tr>
                    <tr>
                        <th>解散日期</th>
                        <td>2023年 (凍結)</td>
                    </tr>
                    <tr>
                        <th>總部類型</th>
                        <td>虛擬組織 (Discord/線上)</td>
                    </tr>
                    <tr>
                        <th>創始成員</th>
                        <td>李子杰、陳柏蓁、李映葳、陳品妤、鍾瑜珍</td>
                    </tr>
                    <tr>
                        <th>末任主席</th>
                        <td>陳柏蓁</td>
                    </tr>
                     <tr>
                        <th>母機構</th>
                        <td><a href="#">金融旅遊</a> (有爭議)</td>
                    </tr>
                </table>
            </div>
            
            <div style="font-size: 0.85rem; color: #666; margin-top: 1rem; border-top: 1px solid #ddd; padding-top: 10px;">
                <b>檔案資訊</b><br>
                編號：CX-ARCHIVE-004<br>
                最後編輯：2025年 (李子杰)
            </div>
        </aside>
    </div>

    <footer class="footer">
        <p>
            本頁面最後修訂於 2025年11月24日 (週一)。<br>
            除非另有聲明，本網站內容採用 <a href="#">CC BY-NC-SA 4.0</a> 授權條款。<br>
            <strong>誠訊工作室 (Chengxun Studio)</strong> 版權所有。
        </p>
        <p>
            <a href="#">隱私權政策</a> | <a href="#">關於誠訊資料庫</a> | <a href="#">免責聲明</a> | <a href="#">手機版檢視</a>
        </p>
    </footer>
</div>

</body>
</html>