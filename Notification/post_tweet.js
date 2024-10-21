const { TwitterApi } = require('twitter-api-v2');

const APIkey = "7GNLCkMd7zYBSgqV2CAASHXTc";
const APIkeySecret = "R49kpYmVooIO1KGoq05mjy4ST8DLIF7eOsLB898V4pkan7wQJT";
const AccessToken = "1459491971232268291-qGeRzJj0QlDRldabFP7ay7YdbEhYVe";
const AccessTokenSecret = "kivDpoqSWm57B1tkAxgXLQfNKbwINkFXHzONeaLAMuO8y";

const client = new TwitterApi({
  appKey: APIkey,
  appSecret: APIkeySecret,
  accessToken: AccessToken,
  accessSecret: AccessTokenSecret,
});

async function postTweet(tweetText) {
  try {
    const tweet = await client.v2.tweet(tweetText);
    console.log(`\x1b[32mTweet posted with ID ${tweet.data.id}\x1b[0m`);
  } catch (error) {
    console.error(`\x1b[31mFailed to post tweet: ${error}\x1b[0m`);
  }
}

postTweet('JUST A TEST NOT REAL!!!!\nEmergency situation alert!!!! : Gunshot detected\nin Siam palagon : https://maps.app.goo.gl/YEwFfvHY1o3Agchx8\nPlease leave that area immediately.\nPolice call : 191');
