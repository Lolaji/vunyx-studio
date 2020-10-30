
import axs from 'axios';

// const google = require('googleapis');

class YoutubeDataApi {
    constructor()
    {

        this.url = '';
        this.api_key = process.env.MIX_YOUTUBE_API_KEY;
    }
    // authenticate() {
        
    // }

    init(callback=null)
    {
        gapi.client.setApiKey(this.api_key);
        return new Promise((resolve, reject) => {
            gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest")
            .then(function() { resolve('Youtube api loaded') },
                  function(err) { reject(err) });
        })
    }
    load()
    {
        gapi.load('client', this.init);
    }
    listVideo()
    {
        axs.get('https://www.googleapis.com/youtube/v3/videos', {
            params: {
                api_key: this.api_key,
                part: 'snippet%2CcontentDetails',
                id: 'JuVhr422hlc'
            },
            headers: {
                "Accept": 'application/json',
                // common: {}
            }
        }).then(res => {
            console.log(res);
        }).catch(err => {
            console.error(err);
        });

        // fetch('')
    }
}

export default new YoutubeDataApi;