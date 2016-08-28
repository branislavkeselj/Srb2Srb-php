<?php

class srb2srb {

    private static $doc;

    private static $num;

    private static $entities=array('(&quot;)', '(&apos;)', '(&amp;)', '(&lt;)', '(&gt;)', '(&nbsp;)', '(&iexcl;)', '(&cent;)', '(&pound;)',
        '(&curren;)', '(&yen;)', '(&brvbar;)', '(&sect;)', '(&uml;)', '(&copy;)', '(&ordf;)', '(&laquo;)', '(&not;)', '(&shy;)',
        '(&reg;)', '(&macr;)', '(&deg;)', '(&plusmn;)', '(&sup2;)', '(&sup3;)', '(&acute;)', '(&micro;)', '(&para;)', '(&middot;)',
        '(&cedil;)', '(&sup1;)', '(&ordm;)', '(&raquo;)', '(&frac14;)', '(&frac12;)', '(&frac34;)', '(&iquest;)', '(&times;)', '(&divide;)',
        '(&Oslash;)', '(&oslash;)', '(&forall;)', '(&part;)', '(&exists;)', '(&empty;)', '(&nabla;)', '(&isin;)', '(&notin;)', '(&ni;)',
        '(&prod;)', '(&sum;)', '(&minus;)', '(&lowast;)', '(&radic;)', '(&prop;)', '(&infin;)', '(&ang;)', '(&and;)', '(&or;)',
        '(&cap;)', '(&cup;)', '(&int;)', '(&there4;)', '(&sim;)', '(&cong;)', '(&asymp;)', '(&ne;)', '(&equiv;)', '(&le;)', '(&ge;)',
        '(&sub;)', '(&sup;)', '(&nsub;)', '(&sube;)', '(&supe;)', '(&oplus;)', '(&otimes;)', '(&perp;)', '(&sdot;)',
        '(&Alpha;)', '(&Beta;)', '(&Gamma;)', '(&Delta;)', '(&Epsilon;)', '(&Zeta;)', '(&Eta;)', '(&Theta;)', '(&Iota;)', '(&Kappa;)',
        '(&Lambda;)', '(&Mu;)', '(&Nu;)', '(&Xi;)', '(&Omicron;)', '(&Pi;)', '(&Rho;)', '(&Sigma;)', '(&Tau;)', '(&Upsilon;)', '(&Phi;)',
        '(&Chi;)', '(&Psi;)', '(&Omega;)', '(&alpha;)', '(&beta;)', '(&gamma;)', '(&delta;)', '(&epsilon;)', '(&zeta;)', '(&eta;)', '(&theta;)',
        '(&iota;)', '(&kappa;)', '(&lambda;)', '(&mu;)', '(&nu;)', '(&xi;)', '(&omicron;)', '(&pi;)', '(&rho;)', '(&sigmaf;)', '(&sigma;)',
        '(&tau;)', '(&upsilon;)', '(&phi;)', '(&chi;)', '(&psi;)', '(&omega;)', '(&thetasym;)', '(&upsih;)', '(&piv;)', '(&OElig;)', '(&oelig;)',
        '(&Scaron;)', '(&scaron;)', '(&Yuml;)', '(&fnof;)', '(&circ;)', '(&tilde;)', '(&ensp;)', '(&emsp;)', '(&thinsp;)', '(&zwnj;)', '(&zwj;)',
        '(&lrm;)', '(&rlm;)', '(&ndash;)', '(&mdash;)', '(&lsquo;)', '(&rsquo;)', '(&sbquo;)', '(&ldquo;)', '(&rdquo;)', '(&bdquo;)', '(&dagger;)',
        '(&Dagger;)', '(&bull;)', '(&hellip;)', '(&permil;)', '(&prime;)', '(&Prime;)', '(&lsaquo;)', '(&rsaquo;)', '(&oline;)', '(&euro;)', '(&trade;)',
        '(&larr;)', '(&uarr;)', '(&rarr;)', '(&darr;)', '(&harr;)', '(&crarr;)', '(&lceil;)', '(&rceil;)', '(&lfloor;)', '(&rfloor;)', '(&loz;)',
        '(&spades;)', '(&clubs;)', '(&hearts;)', '(&diams;)');

    public static $specialWord=array('konju[^avjrshš][a-z]*', 3, 'injek[a-z]*', 2, 'nadživ[a-z]*', 3, 'tanjug[a-z]*', 3, 'panjeliniz[a-z]*', 3, 'injunkt[a-z]*', 2,
        'nadžet[a-z]*',3, 'nadžnj[a-z]*', 3, 'nadžanj[a-z]*', 3, 'nadždrel[a-z]*', 3, 'nadžup[a-z]*', 3, 'odžal[^j][a-z]*', 2,
        'odžaljen', 2, 'podžupan[a-z]*', 3);

    private static $cyr = ['џ', 'љ', 'њ','Џ', 'Џ', 'Љ', 'Љ', 'Њ', 'Њ', 'а', 'б', 'в', 'г', 'д', 'ђ', 'е', 'ж', 'з', 'и', 'ј', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'ћ', 'у', 'ф', 'х', 'ц', 'ч', 'ш',
        'А', 'Б', 'В', 'Г', 'Д', 'Ђ', 'Е', 'Ж', 'З', 'И', 'Ј', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'Ћ', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш'];

    private static $lat = ['dž', 'lj', 'nj','Dž', 'DŽ', 'Lj', 'LJ', 'Nj', 'NJ', 'a', 'b', 'v', 'g', 'd', 'đ', 'e', 'ž', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'ć', 'u', 'f', 'h', 'c', 'č', 'š',
        'A', 'B', 'V', 'G', 'D', 'Đ', 'E', 'Ž', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'Ć', 'U', 'F', 'H', 'C', 'Č', 'Š'];

    public static function encodeScriptTag() {

        return self::encode('/(<script[^>]*>.*?<\/script>)/s');
    }

    public static function encodeStyleTag() {

        return self::encode('/(<style[^>]*>.*?<\/style>)/s');
    }

    public static function encodeInputSubmitTag() {

        $res=array();

        $tag=array('/(<input[^>]*type="submit"[^>]*>)/s', '/(<input[^>]*type="button"[^>]*>)/s');

        foreach ($tag as $v) {

            $res=array_merge($res,self::encode($v));
        }

        return $res;
    }

    public static function encodeAllTag() {

        return self::encode('/(<.*?>)/s');
    }

    public static function encodeHtmlEntities() {

        $res=array();

        foreach (self::$entities as $v) {

            $res=array_merge($res,self::encode('/'.$v.'/'));
        }

        return $res;
    }

    public static function encodeExemption() {

        return self::encode('/({#}.*?{\/#})/s');
    }

    public static function clearExemptionTag() {

        self::$doc= preg_replace('/{#}|{\/#}/', '', self::$doc);
    }

    public static function encodeSpecialWord() {

        $sum=count(self::$specialWord);

        for($i=0;$i<$sum;$i+=2) {

            self::$doc = preg_replace_callback('/' . self::$specialWord[$i] . '/si',function($m) use ($i) {

                return substr($m[0], 0, self::$specialWord[$i + 1]) . '#qq#' . substr($m[0], self::$specialWord[$i + 1]);

            }, self::$doc);
        }
    }

    public static function encode($pattern) {

        $return=array();

        self::$doc = preg_replace_callback($pattern, function($m) use(&$return) {

            self::$num++;

            $return[]=array('k'=>'#' . self::$num . '#','v'=>$m[1]);

            return '#' . self::$num . '#';

        }, self::$doc);

        return $return;
    }

    public static function detectLang() {

        $l = 0;

        $c = 0;

        $lat = implode('', self::$lat);

        $cyr = implode('', self::$cyr);

        $sum=strlen(self::$doc);

        for ($i = 0; $i < $sum; $i++) {

            if (strpos($lat, self::$doc[$i]) !== false) {

                $l++;

                if ($l > 10) return 'lat';
            }
            else if (strpos($cyr, self::$doc[$i]) !== false) {

                $c++;

                if ($c > 10) return 'cyr';
            }
        }

        return false;
    }

    public static function convert($lang,$text='') {

        if($lang=='cyr') {

            $lat = array();

            foreach (self::$lat as $v) {

                $lat[] = '/' . $v . '/';
            }

            return  preg_replace($lat, self::$cyr, $text);
        }
        else {

            $cyr = array();

            foreach (self::$cyr as $v) {

                $cyr[] = '/' . $v . '/';
            }

            return  preg_replace($cyr, self::$lat, $text);
        }
    }

    public static function decode($res) {

        foreach($res as $v) {

            self::$doc = preg_replace('/' . $v['k'] . '/', $v['v'], self::$doc);
        }
    }

    public static function decodeSpecialWord() {

        self::$doc = preg_replace('/#qq#/', '', self::$doc);
    }

    public static function convertInputSubmitTag($lang,&$input) {

        foreach ($input as $k=>$v) {

            $input[$k]['v'] = preg_replace_callback('/value="(.*?)"/', function($m) use($lang) {

                return 'value="' . self::convert($lang,$m[1]) . '"';

            }, $v['v']);
        }
    }

    public static function translate($doc) {

        self::$doc=$doc;

        self::$num=0;

        $exemption=self::encodeExemption();

        $scriptTag=self::encodeScriptTag();

        $styleTag=self::encodeStyleTag();

        $inputSubmitTag=self::encodeInputSubmitTag();

        $allTag=self::encodeAllTag();

        self::encodeSpecialWord();

        $htmlEntities=self::encodeHtmlEntities();

        $lang=self::detectLang();

        if($lang) {

            $lang=$lang=='cyr' ? 'lat':'cyr';

            self::$doc=self::convert($lang,self::$doc);

            self::convertInputSubmitTag($lang,$inputSubmitTag);

            self::decodeSpecialWord();

            self::decode($exemption);

            self::clearExemptionTag();

            self::decode($htmlEntities);

            self::decode($scriptTag);

            self::decode($styleTag);

            self::decode($inputSubmitTag);

            self::decode($allTag);
        }
        else self::$doc='Upsss....';

        return self::$doc;
    }
}

$text='<!DOCTYPE html>
<html>
    <head>
        <title>Srb2Срб</title>
        <meta charset="utf-8" />
    </head>
    <body>
    Ovo je tekst koji se treba prevesti {#} <strong>a ovo je tekst koji se ne prevodi</strong> {/#} takođe ni ovaj {#} <strong>tekst se ne prevodi</strong> {/#}.
    </body>
</html>';

echo srb2srb::translate($text);