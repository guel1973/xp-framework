<?php
  uses(
    'xml.soap.SOAPClient', 
    'xml.soap.transport.SOAPHTTPTransport'
  );
  
  /**
   * GlobalWeather is a new and improved version of our popular AirportWeather 
   * Web service. This Web service returns detailed, strong-typed and 
   * time-stamped weather data, and returns results much faster than 
   * AirportWeather. You can search for valid weather stations by station codes, 
   * country, latitude, longitude, elevation, name or region. You can also use 
   * the isValidCode operation to validate a particular code.
   *
   * Example:
   * <pre>
   * $w= &new GlobalWeather();
   *   try(); {
   *     $report= &$w->getWeatherReport('FRA');
   *   } if (catch('Exception', $e)) {
   *     $e->printStackTrace();
   *     exit;
   *   }
   *   
   *   var_dump($report);
   * </pre>
   * 
   * @see    http://xmethods.net/ve2/ViewListing.po?serviceid=98735
   * @see    http://www.capescience.com/webservices/globalweather/
   * @see    http://www.w3.org/2000/06/webdata/xslt?xslfile=http://www.capescience.com/simplifiedwsdl.xslt&xmlfile=http://live.capescience.com/wsdl/GlobalWeather.wsdl&transform=Submit
   */
  class GlobalWeather extends SOAPClient {
  
    /**
     * Constructor
     *
     * @access  public
     */
    function __construct() {
      parent::__construct(
        new SOAPHTTPTransport('http://live.capescience.com/ccx/GlobalWeather'),
        NULL,
        NULL
      );
    }

    /**
     * Gets weather report by Airport code
     *
     * @access    public
     * @param     string code Airport code, such as "FRA" for Frankfurt/Main, Germany
     * @return    object report
     * @see       http://www.gironet.nl/home/aviator1/iata/iatacode.htm
     * @see       http://www.wajb.freeserve.co.uk/codes.htm
     */
    function &getWeatherReport($code) {
      $this->action= 'capeconnect:GlobalWeather:GlobalWeather';
      $this->method= 'getWeatherReport';
      $report= $this->call(new SOAPNamedItem(
        'code', $code
      ));
      return $report ? $report[0] : FALSE;
    }
  }
?>
