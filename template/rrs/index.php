<?php
//Reading vnexpress XML with the DOM
$doc =new DOMDocument();
$doc->load('http://vnexpress.net/RSS/GL/The-gioi.rss');
$channels=$doc->getElementsByTagName("channel"); // lay noi dung cua tag channel
$newTitles=array();
$newDesciptions=array();
$newLinks=array();
$newPubDates=array();
foreach($channels as $channel)
{
    $Items =$channel->getElementsByTagName("item"); // lay noi dung cua tag item
    foreach($Items as $Item)
    {
        $titles = $Item->getElementsByTagName("title"); 
        $newTitles[]= $titles->item(0)->nodeValue ;
        
        $descriptions = $Item->getElementsByTagName("description"); 
        $newDesciptions[]= $descriptions->item(0)->nodeValue ;
        
        $links = $Item->getElementsByTagName("link"); 
        $newLinks[]= $links->item(0)->nodeValue ;
        
        $pubDates = $Item->getElementsByTagName("pubDate"); 
        $newPubDates[]= $pubDates->item(0)->nodeValue ;
        
    }    
    
}
for($i=0;$i<count($newTitles);$i++)
{
    
    echo $newTitles[$i] ."<br />";
    echo $newDesciptions[$i] ."<br />" ;
    echo "<p>&nbsp;</p>"; 
    // Xử lý tiếp nha các bạn
}
?> 