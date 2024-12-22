<?php

function extract_common_words($string, $stop_words = [], $max_count = 10) {
//    $string = preg_replace('/ss+/i', '', $string);
    $string = trim($string); // trim the string
    $string = preg_replace('/[^a-zA-Z -]/', '', $string); // only take alphabet characters, but keep the spaces and dashes too…
    $string = strtolower($string); // make it lowercase

    preg_match_all('/\b.*?\b/i', $string, $match_words);
    $match_words = $match_words[0];

    foreach ( $match_words as $key => $item ) {
        if ( $item == '' || in_array(strtolower($item), $stop_words) || strlen($item) <= 3 ) {
            unset($match_words[$key]);
        }
    }

    $word_count = str_word_count( implode(" ", $match_words) , 1);
    $frequency = array_count_values($word_count);
    arsort($frequency);

    //arsort($word_count_arr);
    $keywords = array_slice($frequency, 0, $max_count);
    return $keywords;
}

function modify_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
    $stop_words = ["a's",    "able",    "about",    "above",    "according",    "accordingly",    "across",    "actually",    "after",    "afterwards",    "again",    "against",    "ain't",    "all",    "allow",    "allows",    "almost",    "alone",    "along",    "already",    "also",    "although",    "always",    "am",    "among",    "amongst",    "an",    "and",    "another",    "any",    "anybody",    "anyhow",    "anyone",    "anything",    "anyway",    "anyways",    "anywhere",    "apart",    "appear",    "appreciate",    "appropriate",    "are",    "aren't",    "around",    "as",    "aside",    "ask",    "asking",    "associated",    "at",    "available",    "away",    "awfully",    "be",    "became",    "because",    "become",    "becomes",    "becoming",    "been",    "before",    "beforehand",    "behind",    "being",    "believe",    "below",    "beside",    "besides",    "best",    "better",    "between",    "beyond",    "both",    "brief",    "but",    "by",    "c'mon",    "c's",    "came",    "can",    "can't",    "cannot",    "cant",    "cause",    "causes",    "certain",    "certainly",    "changes",    "clearly",    "co",    "com",    "come",    "comes",    "concerning",    "consequently",    "consider",    "considering",    "contain",    "containing",    "contains",    "corresponding",    "could",    "couldn't",    "course",    "currently",    "definitely",    "described",    "despite",    "did",    "didn't",    "different",    "do",    "does",    "doesn't",    "doing",    "don't",    "done",    "down",    "downwards",    "during",    "each",    "edu",    "eg",    "eight",    "either",    "else",    "elsewhere",    "enough",    "entirely",    "especially",    "et",    "etc",    "even",    "ever",    "every",    "everybody",    "everyone",    "everything",    "everywhere",    "ex",    "exactly",    "example",    "except",    "far",    "few",    "fifth",    "first",    "five",    "followed",    "following",    "follows",    "for",    "former",    "formerly",    "forth",    "four",    "from",    "further",    "furthermore",    "get",    "gets",    "getting",    "given",    "gives",    "go",    "goes",    "going",    "gone",    "got",    "gotten",    "greetings",    "had",    "hadn't",    "happens",    "hardly",    "has",    "hasn't",    "have",    "haven't",    "having",    "he",    "he's",    "hello",    "help",    "hence",    "her",    "here",    "here's",    "hereafter",    "hereby",    "herein",    "hereupon",    "hers",    "herself",    "hi",    "him",    "himself",    "his",    "hither",    "hopefully",    "how",    "howbeit",    "however",    "i'd",    "i'll",    "i'm",    "i've",    "ie",    "if",    "ignored",    "immediate",    "in",    "inasmuch",    "inc",    "indeed",    "indicate",    "indicated",    "indicates",    "inner",    "insofar",    "instead",    "into",    "inward",    "is",    "isn't",    "it",    "it'd",    "it'll",    "it's",    "its",    "itself",    "just",    "keep",    "keeps",    "kept",    "know",    "known",    "knows",    "last",    "lately",    "later",    "latter",    "latterly",    "least",    "less",    "lest",    "let",    "let's",    "like",    "liked",    "likely",    "little",    "look",    "looking",    "looks",    "ltd",    "mainly",    "many",    "may",    "maybe",    "me",    "mean",    "meanwhile",    "merely",    "might",    "more",    "moreover",    "most",    "mostly",    "much",    "must",    "my",    "myself",    "name",    "namely",    "nd",    "near",    "nearly",    "necessary",    "need",    "needs",    "neither",    "never",    "nevertheless",    "new",    "next",    "nine",    "no",    "nobody",    "non",    "none",    "noone",    "nor",    "normally",    "not",    "nothing",    "novel",    "now",    "nowhere",    "obviously",    "of",    "off",    "often",    "oh",    "ok",    "okay",    "old",    "on",    "once",    "one",    "ones",    "only",    "onto",    "or",    "other",    "others",    "otherwise",    "ought",    "our",    "ours",    "ourselves",    "out",    "outside",    "over",    "overall",    "own",    "particular",    "particularly",    "per",    "perhaps",    "placed",    "please",    "plus",    "possible",    "presumably",    "probably",    "provides",    "que",    "quite",    "qv",    "rather",    "rd",    "re",    "really",    "reasonably",    "regarding",    "regardless",    "regards",    "relatively",    "respectively",    "right",    "said",    "same",    "saw",    "say",    "saying",    "says",    "second",    "secondly",    "see",    "seeing",    "seem",    "seemed",    "seeming",    "seems",    "seen",    "self",    "selves",    "sensible",    "sent",    "serious",    "seriously",    "seven",    "several",    "shall",    "she",    "should",    "shouldn't",    "since",    "six",    "so",    "some",    "somebody",    "somehow",    "someone",    "something",    "sometime",    "sometimes",    "somewhat",    "somewhere",    "soon",    "sorry",    "specified",    "specify",    "specifying",    "still",    "sub",    "such",    "sup",    "sure",    "t's",    "take",    "taken",    "tell",    "tends",    "th",    "than",    "thank",    "thanks",    "thanx",    "that",    "that's",    "thats",    "the",    "their",    "theirs",    "them",    "themselves",    "then",    "thence",    "there",    "there's",    "thereafter",    "thereby",    "therefore",    "therein",    "theres",    "thereupon",    "these",    "they",    "they'd",    "they'll",    "they're",    "they've",    "think",    "third",    "this",    "thorough",    "thoroughly",    "those",    "though",    "three",    "through",    "throughout",    "thru",    "thus",    "to",    "together",    "too",    "took",    "toward",    "towards",    "tried",    "tries",    "truly",    "try",    "trying",    "twice",    "two",    "un",    "under",    "unfortunately",    "unless",    "unlikely",    "until",    "unto",    "up",    "upon",    "us",    "use",    "used",    "useful",    "uses",    "using",    "usually",    "value",    "various",    "very",    "via",    "viz",    "vs",    "want",    "wants",    "was",    "wasn't",    "way",    "we",    "we'd",    "we'll",    "we're",    "we've",    "welcome",    "well",    "went",    "were",    "weren't",    "what",    "what's",    "whatever",    "when",    "whence",    "whenever",    "where",    "where's",    "whereafter",    "whereas",    "whereby",    "wherein",    "whereupon",    "wherever",    "whether",    "which",    "while",    "whither",    "who",    "who's",    "whoever",    "whole",    "whom",    "whose",    "why",    "will",    "willing",    "wish",    "with",    "within",    "without",    "won't",    "wonder",    "would",    "wouldn't",    "yes",    "yet",    "you",    "you'd",    "you'll",    "you're",    "you've",    "your",    "yours",    "yourself",    "yourselves",    "zero"];

    if(!$html) {
        return "";
    }

    global $in_single_content;

    if(!is_single() && !is_page()) {
        $html = "<figure class='alignleft archive-entry-content-thumbnail'>{$html}</figure>";
    } else if( isset($in_single_content) && $in_single_content === false ) {
        $html = "<figure class='alignleft archive-entry-content-thumbnail'>{$html}</figure>";
    } else {
        $caption = implode(', ', array_keys(extract_common_words(strip_tags(get_the_content($post_id)), $stop_words)));
        $html = "<figure class='alignright single-entry-content-thumbnail'>{$html}</figure>";
    }

    if(strpos($html, ' alt=""') !== false) {
        $html = str_replace(' alt=""', ' alt="'.get_the_title($post_id).'"', $html);
    }

    if(strpos($html, ' alt>') !== false || strpos($html, ' alt ') !== false) {
        $html = str_replace(' alt', ' alt="'.get_the_title($post_id).'"', $html);
    }

    if(strpos($html, ' alt') === false) {
        $html = str_replace('>', ' alt="'.get_the_title($post_id).'">', $html);
    }
    
    $html = str_replace(' alt', ' title="'.get_post_meta($post_id, '_yoast_wpseo_title', true).'" alt', $html);

    $content = apply_filters('the_content', get_the_content($post_id));
    preg_match('/^<p>(.+?)<\/p>/', $content, $match);

    if(!trim(strip_tags($match[0])) && (is_single() || is_page()) && !isset($in_single_content)) {
//        return "";
    } else {

    }


    return $html;
}

/* 
    Removed By Egzon Hasi
    On 01/03/2021 Since SEO Team's future plans are to remove them from every page
    add_filter('post_thumbnail_html', 'modify_post_thumbnail_html', 99, 5);
*/