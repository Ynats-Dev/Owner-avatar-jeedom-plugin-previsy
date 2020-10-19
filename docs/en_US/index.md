---
layout: default
lang: en_US
---

Description
===

This plugin announces the next weather alerts (72H) in France, Belgium and Switzerland. Previsy also builds sentences that can be used to be sent to you by sms, announced by your home or slack etc...

## Examples of use

### Everyday life alerts

> You wish to know where to hang the laundry? Prévisy will announce you that the next rain is in 14H and there will be a little wind it's worth to hang it outside.

> Have you just opened a velux? Prévisy will announce the next rainfall to think about closing it or help you to automatically set an alert one hour before the rain.

### Indicators for athletes

> The day after tomorrow in 31H, Previsy announces you a good breeze. Ideal for windsurfing !

> Passionate about snowboarding, are you waiting for the next snowfall? Previsy tells you that the snow stops falling this weekend, it's coming down pretty well!

As you can see, forecasts can help you in many ways.

## Two ways to use Previsy

### With the widget and prebuilt sentences.

![previsy1](../images/widget-sans-txt.png)

### Using the raw data directly

You will, of course, be able to retrieve the raw data to create your scenarios and associate them with services (SMS, Slack, Notification, etc.).

![previsy2](../images/commandes.png)

Installation
===

## The plugin uses prevision-meteo.ch forecast 

Prevision-meteo.ch is very regularly saturated. To overcome this problem, Previsy caches the API data and uses it to refresh the widgets if the API is unavailable or too long to respond.


## Configuration

![previsy3](../images/config-1.png)

### Number of alerts expected to be displayed

This allows you to configure the number of alerts you wish to display. 

**Exemple**
> "You wish to display only the next 2 alerts."

### Temperature
You can display temperatures in degrees Celsius (°C) or Fahrenheit (°F).

### Commands to display (optional for your scenarios)
Data allowing you to create your custom scenarios. You just have to check the commands you wish to see appear. You probably won't need to use all of them. (all commands will be described later). 

**Warning**
> If you want to display 5 alerts and all the commands you will get a lot of them! 

### Scheduled task (cron)
If you disable the scheduled task that takes place every hour ... the plugin will be useless ...

![previsy4](../images/config-2.png)

Management
===

## Equipment

![previsy5](../images/parametre-1.png)

### City
Here you enter the name of the city you wish to survey. To allow you to test, a button will be displayed on the right of the entry to test directly on the site prevision-meteo.ch
If the site is offline or takes a long time to answer, you will have to try again later.

> In the url the keyword of the city: https://www.prevision-meteo.ch/meteo/localite/yourcity

![previsy6](../images/parametre-saisie.png)

### Coordinates of the localisation

Fill in the latitude and longitude of the location you wish to survey. If you enter coordinates, the city will not be taken into account.

> In the url the coordinates: https://www.prevision-meteo.ch/meteo/localite/lat=01.500lng=65.100

### Display predictive text in the widget

![previsy7](../images/widget-txt.png)

This allows to display the predictive text in the widget.
Weather warnings (rain, snow, etc...) have priority over wind warnings.

### Wind alert threshold

![previsy8](../images/parametre-vent.png)

You can set the wind threshold according to the locality. The "wind" alert will not be triggered below this threshold.

## Controls

![previsy9](../images/parametre-commandes.png)

> The number of orders will necessarily be proportional to the number of alerts you have configured.

### General controls

| Type | Control | Description |
| ------------ | ------------ | ------------ | 
| info | SynchroVille | This corresponds to the city you have registered. |
| info | SynchroLastUpDate | Date in "timestamp" format of the last synchronization with the website prevision-meteo.ch. | 
| info | Latitude | As its name indicates | 
| info | Longitude | As its name indicates | 
| info | Type_degre | °C ou °F | 
| action | Rafraichir | The famous command to refresh the widget. This will launch a synchro at prevision-meteo.ch. | 

### Controls related to alerts

> The following commands are linked to alert 1 identified by the "01". The more alerts there are, the more commands there will be.

| Type | Controls | Description |
| ------------ | ------------ | ------------ |
| info | Alerte+01_txt_full | This is the complete sentence. It includes all the indications related to the weather. Example: "In 18 hours, that is to say tomorrow from 4 p.m., it will rain for 1 hour. There will be a total of 0.3 millimeters of precipitation. The humidity level will be 99.0%. The temperature will be 10.5°C. The wind will blow on average at 24.0 km/hr with gusts up to 38.0 km/hr." |  
| info | Alerte+01_txt_start | This is the first part of the sentence. Example: "In 18 hours, tomorrow from 4pm, it's going to rain for 1 hour." | 
| info | Alerte+01_txt_mm | This is the part of the sentence related to precipitation. Example: "There will be a total of 0.3 millimeters of precipitation." | 
| info | Alerte+01_txt_humidite  | This is the part of the sentence related to moisture. Example: "The moisture content will be 99.0%." | 
| info | Alerte+01_txt_temperature | This is the part of the sentence related to temperature. Example: "The temperature will be 10.5°C." | 
| info | Alerte+01_txt_vent | This is the part of the sentence related to the wind. Example: "The wind will blow at an average of 24.0 km/h with gusts up to 38.0 km/h". | 

> VYou will have understood it, it will allow you to compose your sentences as you wish!

| Type | Controls | Description |
| ------------ | ------------ | ------------ | 
| info | Alerte+01_dans_heure | Next alert in time. |
| info | Alerte+01_date_start | Start date of the next alert in YmdHi format. | 
| info | Alerte+01_date_end | End date of the next alert in YmdHi format. | 
| info | Alerte+01_type | Type of alert (rain, snow, snow_rain, thunderstorm, fog or wind). | 
| info | Alerte+01_condition_max | Description of the Highest Alert. | 
| info | Alerte+01_duree | Duration of the alert (of the same type and successive). | 
| info | Alerte+01_mm_min | Minimum rainfall |
| info | Alerte+01_mm_max | Maximum rainfall. | 
| info | Alerte+01_mm_moyenne | Average rainfall. | 
| info | Alerte+01_mm_total | Total rainfall. | 
| info | Alerte+01_temp_min | Minimum temperature. | 
| info | Alerte+01_temp_max | Maximum temperature. | 
| info | Alerte+01_temp_moyenne | Average temperature. | 
| info | Alerte+01_humidite_min | Minimum humidity. | 
| info | Alerte+01_humidite_max | Maximum humidity. | 
| info | Alerte+01_humidite_moyenne | Average humidity. | 
| info | Alerte+01_vent_min | Minimum wind speed. | 
| info | Alerte+01_vent_max | Maximum wind speed. | 
| info | Alerte+01_vent_moyenne | Average wind speed. | 
| info | Alerte+01_rafale_min | Minimum gust speed. | 
| info | Alerte+01_rafale_max | Maximum gust speed. | 
| info | Alerte+01_rafale_moyenne | Average gust speed. | 