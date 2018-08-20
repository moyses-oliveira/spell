<?php

/**
 * Simplify friendly URL Managment
 * 
 *  
 * @author Moysés Filipe Lopes Peixoto de Oliveira
 * @version 1.0
 * @access public
 * @modification 2016-10-20
 */

namespace Spell\Server;

use Spell\Flash\Server;

class URS {

    /**
     *
     * @var string 
     */
    private $site;

    /**
     *
     * @var string 
     */
    private $index;

    /**
     *
     * @var string 
     */
    private $root;

    /**
     *
     * @var array 
     */
    private $params = [];

    /**
     *
     * @var array 
     */
    private $vars = [];

    /**
     * 
     * @param string $site
     */
    public function __construct(string $site)
    {
        $this->site = '//' . strtolower(trim($site, '/')) . '/';
        $this->index = preg_replace('/\/\/[a-zA-Z\d:\._-]+\/([\S]+)/', '$1', $this->site);
        $this->root = str_replace('index.php', '', $_SERVER['PHP_SELF']);
        $this->extract();
    }

    /**
     * Extract URL parameters from friendly URL
     */
    public function extract()
    {
        $uri = current(explode('?', $_SERVER['REQUEST_URI']));
        $break = explode(rtrim($this->index, '/'), $uri);
        if(empty($break[0]))
            unset($break[0]);

        $url = implode($this->index, $break);

        $urls = explode('/', $url);
        $this->extractParams($urls);
        $this->extractVars($urls);
    }

    /**
     * Extract URL parameters from friendly URL
     * 
     * @param array $urls
     */
    private function extractParams(array $urls)
    {
        $this->params = [];
        foreach($urls as $v):
            $v .= '';
            if(!!strlen($v) && count(explode(':', $v)) == 1)
                $this->params[] = $v;
        endforeach;
    }

    /**
     * Extract URL variables from friendly URL
     * 
     * @param array $urls
     */
    private function extractVars(array $urls)
    {
        $this->vars = [];
        foreach($urls as $k => $v):
            $brk = explode(':', $v);
            $key = array_shift($brk);
            $val = implode(':', $brk);
            if(empty($v))
                continue;

            if($k > 0 && count(explode(':', $v)) > 1)
                $this->vars[$key] = $val;
        endforeach;
    }

    /**
     * Current page url
     * 
     * @return string
     */
    public function currentPage(): string
    {
        return $this->getServerName() . Server::getUri();
    }

    /**
     * Server Name
     * 
     * @return string
     */
    public function getServerName(): string
    {
        return '//' . Server::getName();
    }

    /**
     * Index Server Name without path 
     * 
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * Root path server URI 
     * 
     * @return string
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    /**
     * Website url
     * 
     * @return string
     */
    public function getSite(): string
    {
        return $this->site;
    }

    /**
     * Current URI
     * 
     * @return string
     */
    public function getUri(): string
    {
        return Server::getUri();
    }

    /**
     * List of friendly URL parameters
     * 
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * List of friendly URL variables
     * 
     * @return array
     */
    public function getVars(): array
    {
        return $this->vars;
    }

    /**
     * URL variable by key
     * 
     * @param type $v
     * @return string|null
     */
    public function getVar($v): ?string
    {
        if(isset($this->vars[$v]))
            return $this->vars[$v];
        else
            return null;
    }

    /**
     * URL parameter by key
     * 
     * @param type $k
     * @return string|null
     */
    public function getParam($k): ?string
    {
        if(isset($this->params[$k]))
            return $this->params[$k];
        else
            return null;
    }

    /**
     * URL build path
     * 
     * @return string
     */
    public function getPath(): string
    {
        return $this->root() . implode('/', func_get_args());
    }

    /**
     * Current URL protocol schema
     * 
     * @return string
     */
    public function getSchema(): string
    {
        if(!isset($_SERVER["HTTPS"]))
            return 'http';

        return ($_SERVER["HTTPS"] == "on" ? "https" : "http");
    }

    /**
     * Build friendly URL using string with accents, spaces and special characters
     * 
     * @param string $str
     * @param string $code
     * @param string $ext
     * @return string
     */
    public function build(string $str, string $code, string $ext = 'html'): string
    {
        return sprintf('%s.%s.%s', $this->normalize($str), base_convert($code, 10, 36), $ext);
    }

    /**
     * 
     * @param string $str
     * @param array $replace
     * @param string $delimiter
     * @return string
     */
    public function normalize(string $str, array $replace = [], string $delimiter = '-'): string
    {
        setlocale(LC_ALL, 'en_US.UTF8');
        if(!empty($replace)) {
            $str = str_replace((array) $replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    /**
     * Get code from builded friendly URL 
     * 
     * @param string $url
     * @return string|null
     */
    public function getCode(string $url): ?string
    {
        $brkParams = explode('?', $url);
        $currentUrl = current($brkParams);
        $matches = [];
        preg_match('/\.([a-z0-9]+)\.[a-z0-9]{3,4}$/', $currentUrl, $matches); #, PREG_OFFSET_CAPTURE, 3);
        if(is_array($matches)):
            $math = end($matches);
            if(!$math): return null;
            elseif(!is_array($math)): return base_convert($math, 36, 10);
            else: return null;
            endif;
        endif;
        return null;
    }

    /**
     * 
     * @param string $url
     * @param string $key
     * @return string
     */
    public function getParamsFromStr(string $url, string $key): string
    {
        $query_str = parse_url($url, PHP_URP_QUERY);
        $query_params = [];
        parse_str($query_str, $query_params);
        return isset($query_params[$key]) ? $query_params[$key] : null;
    }

    /**
     * Extract baseDomain from current URL
     * 
     * @return string|null
     * @throws \Exception
     */
    public function baseDomain(): ?string
    {
        $is_ip = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', Server::getName(false));
        if($is_ip)
            throw new \Exception('This system dont\'t support IP access');

        $matches = [];
        $pattern = '/[a-z0-9\-]+(\.[a-z0-9\-]{2,3}$|\.[a-z0-9\-]{2,3}\.[a-z0-9\-]{2,3}$)/';
        preg_match($pattern, Server::getName(false), $matches, PREG_OFFSET_CAPTURE, 0);

        if(!is_array($matches))
            return Server::getName(false);

        return current(current($matches));
    }

    /**
     * Check if string is an domain name
     * 
     * @param string $d
     * @param bool $clean
     * @return bool
     */
    public function isDomain(string $d, bool $clean = false): bool
    {
        if($clean === true)
            $d = $this->cleanURL($d);
        $tlds = "/^[-a-z0-9]{1,63}\.(ac\.nz|co\.nz|geek\.nz|gen\.nz|kiwi\.nz|maori\.nz|net\.nz|org\.nz|school\.nz|ae|ae\.org|com\.af|asia|asn\.au|auz\.info|auz\.net|com\.au|id\.au|net\.au|org\.au|auz\.biz|az|com\.az|int\.az|net\.az|org\.az|pp\.az|biz\.fj|com\.fj|info\.fj|name\.fj|net\.fj|org\.fj|pro\.fj|or\.id|biz\.id|co\.id|my\.id|web\.id|biz\.ki|com\.ki|info\.ki|ki|mobi\.ki|net\.ki|org\.ki|phone\.ki|biz\.pk|com\.pk|net\.pk|org\.pk|pk|web\.pk|cc|cn|com\.cn|net\.cn|org\.cn|co\.in|firm\.in|gen\.in|in|in\.net|ind\.in|net\.in|org\.in|co\.ir|ir|co\.jp|jp|jp\.net|ne\.jp|or\.jp|co\.kr|kr|ne\.kr|or\.kr|co\.th|in\.th|com\.bd|com\.hk|hk|idv\.hk|org\.hk|com\.jo|jo|com\.kz|kz|org\.kz|com\.lk|lk|org\.lk|com\.my|my|com\.nf|info\.nf|net\.nf|nf|web\.nf|com\.ph|ph|com\.ps|net\.ps|org\.ps|ps|com\.sa|com\.sb|net\.sb|org\.sb|com\.sg|edu\.sg|org\.sg|per\.sg|sg|com\.tw|tw|com\.vn|net\.vn|org\.vn|vn|cx|fm|io|la|mn|nu|qa|tk|tl|tm|to|tv|ws|academy|careers|education|training|bike|biz|cat|co|com|info|me|mobi|name|net|org|pro|tel|travel|xxx|blackfriday|clothing|diamonds|shoes|tattoo|voyage|build|builders|construction|contractors|equipment|glass|lighting|plumbing|repair|solutions|buzz|sexy|singles|support|cab|limo|camera|camp|gallery|graphics|guitars|hiphop|photo|photography|photos|pics|center|florist|institute|christmas|coffee|kitchen|menu|recipes|company|enterprises|holdings|management|ventures|computer|systems|technology|directory|guru|tips|wiki|domains|link|estate|international|land|onl|pw|today|ac\.im|co\.im|com\.im|im|ltd\.co\.im|net\.im|org\.im|plc\.co\.im|am|at|co\.at|or\.at|ba|be|bg|biz\.pl|com\.pl|info\.pl|net\.pl|org\.pl|pl|biz\.tr|com\.tr|info\.tr|tv\.tr|web\.tr|by|ch|co\.ee|ee|co\.gg|gg|co\.gl|com\.gl|co\.hu|hu|co\.il|org\.il|co\.je|je|co\.nl|nl|co\.no|no|co\.rs|in\.rs|rs|co\.uk|org\.uk|uk\.net|com\.de|de|com\.es|es|nom\.es|org\.es|com\.gr|gr|com\.hr|com\.mk|mk|com\.mt|net\.mt|org\.mt|com\.pt|pt|com\.ro|ro|com\.ru|net\.ru|ru|su|com\.ua|ua|cz|dk|eu|fi|fr|pm|re|tf|wf|yt|gb\.net|ie|is|it|li|lt|lu|lv|md|mp|se|se\.net|si|sk|ac|ag|co\.ag|com\.ag|net\.ag|nom\.ag|org\.ag|ai|com\.ai|com\.ar|as|biz\.pr|com\.pr|net\.pr|org\.pr|pr|biz\.tt|co\.tt|com\.tt|tt|bo|com\.bo|com\.br|net\.br|tv\.br|bs|com\.bs|bz|co\.bz|com\.bz|net\.bz|org\.bz|ca|cl|co\.cr|cr|co\.dm|dm|co\.gy|com\.gy|gy|co\.lc|com\.lc|lc|co\.ms|com\.ms|ms|org\.ms|co\.ni|com\.ni|co\.ve|com\.ve|co\.vi|com\.vi|com\.co|net\.co|nom\.co|com\.cu|cu|com\.do|do|com\.ec|ec|info\.ec|net\.ec|com\.gt|gt|com\.hn|hn|com\.ht|ht|net\.ht|org\.ht|com\.jm|com\.kn|kn|com\.mx|mx|com\.pa|com\.pe|pe|com\.py|com\.sv|com\.uy|uy|com\.vc|net\.vc|org\.vc|vc|gd|gs|north\.am|south\.am|us|us\.org|sx|tc|vg|cd|cg|cm|co\.cm|com\.cm|net\.cm|co\.ke|or\.ke|co\.mg|com\.mg|mg|net\.mg|org\.mg|co\.mw|com\.mw|coop\.mw|mw|co\.na|com\.na|na|org\.na|co\.ug|ug|co\.za|com\.ly|ly|com\.ng|ng|com\.sc|sc|mu|rw|sh|so|st|club|kiwi|uno|email|ruhr)$/i";
        if(preg_match($tlds, $d))
            return true;
        else
            return false;
    }

    /**
     * 
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public function cleanURL(string $url): ?string
    {
        $domain = [];
        $normalize = preg_replace("/(^(http(s)?:\/\/|www\.))?(www\.)?([a-z-\.0-9]+)/", "$5", trim($url));
        if(!preg_match("/^([a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6})/", $normalize, $domain))
            throw new \Exception('not valid domain or subdomain' . $url);

        return $domain[1];
    }

}
