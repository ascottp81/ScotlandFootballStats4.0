<?php

namespace Tests\Unit;

use App\Models\Match;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchTest extends TestCase
{
    /* BelongsTo Relationships */

    /**
     * Test the opponent.
     *
     * @return void
     */
    public function testMatchOpponent()
    {
        $match = factory(Match::class)->make();

        $this->assertEquals('West Germany', $match->opponent->name);
    }

    /**
     * Test the competition.
     *
     * @return void
     */
    public function testMatchCompetition()
    {
        $match = factory(Match::class)->make(['competition_id' => '147', 'other_competition_id' => '1']);

        $this->assertEquals('World Cup 2018 Qualifiers', $match->competition->name);
        $this->assertEquals('Friendly', $match->otherCompetition->name);
    }

    /**
     * Test the competition round.
     *
     * @return void
     */
    public function testMatchCompetitionRound()
    {
        $match = factory(Match::class)->make(['round_id' => '2']);

        $this->assertEquals('Group Stages', $match->competitionRound->name);
    }

    /**
     * Test the match location.
     *
     * @return void
     */
    public function testMatchLocation()
    {
        $match = factory(Match::class)->make(['location_id' => '41']);

        $this->assertEquals('Glasgow', $match->location->city);
    }

    /**
     * Test the match manager.
     *
     * @return void
     */
    public function testMatchManager()
    {
        $match = factory(Match::class)->make(['manager_id' => '16']);

        $this->assertEquals('Brown', $match->manager->surname);
        $this->assertEquals('Craig', $match->manager->firstname);
    }


    /* Accessors */

    /**
     * Test the scoreline for a home match.
     *
     * @return void
     */
    public function testHomeScoreline()
    {
        $match = factory(Match::class)->make(['ha' => 'H']);

        $this->assertEquals('Scotland 1-0 West Germany', $match->scoreline);
        $this->assertEquals('Scotland 1-0 W. Germany', $match->short_scoreline);
    }

    /**
     * Test the scoreline for an away match.
     *
     * @return void
     */
    public function testAwayScoreline()
    {
        $match = factory(Match::class)->make(['ha' => 'A']);

        $this->assertEquals('West Germany 0-1 Scotland', $match->scoreline);
        $this->assertEquals('W. Germany 0-1 Scotland', $match->short_scoreline);
    }

    /**
     * Test the scoreline for a neutral match with Scotland first.
     *
     * @return void
     */
    public function testNeutralHomeScoreline()
    {
        $match = factory(Match::class)->make(['ha' => 'N1']);

        $this->assertEquals('Scotland 1-0 West Germany', $match->scoreline);
        $this->assertEquals('Scotland 1-0 W. Germany', $match->short_scoreline);
    }

    /**
     * Test the scoreline for a neutral match with Scotland second.
     *
     * @return void
     */
    public function testNeutralScoreline()
    {
        $match = factory(Match::class)->make(['ha' => 'N']);

        $this->assertEquals('West Germany 0-1 Scotland', $match->scoreline);
        $this->assertEquals('W. Germany 0-1 Scotland', $match->short_scoreline);
    }


    /**
     * Test the home match score.
     *
     * @return void
     */
    public function testHomeScore()
    {
        $match = factory(Match::class)->make(['ha' => 'H']);

        $this->assertEquals('1-0', $match->score);
    }

    /**
     * Test the neutral match score with Scotland first.
     *
     * @return void
     */
    public function testNeutralHomeScore()
    {
        $match = factory(Match::class)->make(['ha' => 'N1']);

        $this->assertEquals('1-0', $match->score);
    }

    /**
     * Test the away match score.
     *
     * @return void
     */
    public function testAwayScore()
    {
        $match = factory(Match::class)->make(['ha' => 'A']);

        $this->assertEquals('0-1', $match->score);
    }

    /**
     * Test the neutral match score.
     *
     * @return void
     */
    public function testNeutralScore()
    {
        $match = factory(Match::class)->make(['ha' => 'N']);

        $this->assertEquals('0-1', $match->score);
    }

    /**
     * Test the sitemap scoreline.
     *
     * @return void
     */
    public function testSitemapScoreline()
    {
        $match = factory(Match::class)->make();

        $this->assertEquals('Scotland 1-0 W. Germany, 1996', $match->sitemap_scoreline);
    }


    /**
     * Test the home match url.
     *
     * @return void
     */
    public function testHomeUrl()
    {
        $match = factory(Match::class)->make(['ha' => 'H']);

        $this->assertEquals('18-06-1996/scotland-west-germany', $match->url);
    }

    /**
     * Test the neutral match url with Scotland first.
     *
     * @return void
     */
    public function testNeutralHomeUrl()
    {
        $match = factory(Match::class)->make(['ha' => 'N1']);

        $this->assertEquals('18-06-1996/scotland-west-germany', $match->url);
    }

    /**
     * Test the away match url.
     *
     * @return void
     */
    public function testAwayUrl()
    {
        $match = factory(Match::class)->make(['ha' => 'A']);

        $this->assertEquals('18-06-1996/west-germany-scotland', $match->url);
    }

    /**
     * Test the neutral match url.
     *
     * @return void
     */
    public function testNeutralUrl()
    {
        $match = factory(Match::class)->make(['ha' => 'N']);

        $this->assertEquals('18-06-1996/west-germany-scotland', $match->url);
    }

}
