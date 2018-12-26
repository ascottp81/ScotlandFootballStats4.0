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

        $this->assertEquals('Glasgow', $match->location->name);
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

    /**
     * Test the fixture for a home match.
     *
     * @return void
     */
    public function testHomeFixture()
    {
        $match = factory(Match::class)->make(['ha' => 'H']);

        $this->assertEquals('Scotland v West Germany', $match->fixture);
        $this->assertEquals('Scotland v W. Germany', $match->short_fixture);
    }

    /**
     * Test the fixture for an away match.
     *
     * @return void
     */
    public function testAwayFixture()
    {
        $match = factory(Match::class)->make(['ha' => 'A']);

        $this->assertEquals('West Germany v Scotland', $match->fixture);
        $this->assertEquals('W. Germany v Scotland', $match->short_fixture);
    }

    /**
     * Test the fixture for a neutral match with Scotland first.
     *
     * @return void
     */
    public function testNeutralHomeFixture()
    {
        $match = factory(Match::class)->make(['ha' => 'N1']);

        $this->assertEquals('Scotland v West Germany', $match->fixture);
        $this->assertEquals('Scotland v W. Germany', $match->short_fixture);
    }

    /**
     * Test the fixture for a neutral match with Scotland second.
     *
     * @return void
     */
    public function testNeutralFixture()
    {
        $match = factory(Match::class)->make(['ha' => 'N']);

        $this->assertEquals('West Germany v Scotland', $match->fixture);
        $this->assertEquals('W. Germany v Scotland', $match->short_fixture);
    }

    /**
     * Test the home team for a home match.
     *
     * @return void
     */
    public function testHomeHomeTeam()
    {
        $match = factory(Match::class)->make(['ha' => 'H']);

        $this->assertEquals('Scotland', $match->home_team);
    }

    /**
     * Test the home team for a neutral match with Scotland first.
     *
     * @return void
     */
    public function testNeutralHomeHomeTeam()
    {
        $match = factory(Match::class)->make(['ha' => 'N1']);

        $this->assertEquals('Scotland', $match->home_team);
    }

    /**
     * Test the home team for an away match.
     *
     * @return void
     */
    public function testAwayHomeTeam()
    {
        $match = factory(Match::class)->make(['ha' => 'A']);

        $this->assertEquals('West Germany', $match->home_team);
    }

    /**
     * Test the home team for a neutral match with Scotland first.
     *
     * @return void
     */
    public function testNeutralHomeTeam()
    {
        $match = factory(Match::class)->make(['ha' => 'N']);

        $this->assertEquals('West Germany', $match->home_team);
    }

    /**
     * Test the away team for a home match.
     *
     * @return void
     */
    public function testHomeAwayTeam()
    {
        $match = factory(Match::class)->make(['ha' => 'H']);

        $this->assertEquals('West Germany', $match->away_team);
    }

    /**
     * Test the away team for a neutral match with Scotland first.
     *
     * @return void
     */
    public function testNeutralHomeAwayTeam()
    {
        $match = factory(Match::class)->make(['ha' => 'N1']);

        $this->assertEquals('West Germany', $match->away_team);
    }

    /**
     * Test the away team for an away match.
     *
     * @return void
     */
    public function testAwayAwayTeam()
    {
        $match = factory(Match::class)->make(['ha' => 'A']);

        $this->assertEquals('Scotland', $match->away_team);
    }

    /**
     * Test the away team for a neutral match with Scotland first.
     *
     * @return void
     */
    public function testNeutralAwayTeam()
    {
        $match = factory(Match::class)->make(['ha' => 'N']);

        $this->assertEquals('Scotland', $match->away_team);
    }


    /**
     * Test the kickoff text.
     *
     * @return void
     */
    public function testKickoff()
    {
        $match = factory(Match::class)->make(['kickoff' => '20:00 (19:00 UK)']);

        $this->assertEquals('20:00 (19:00 UK)', $match->kickoff);
    }

    /**
     * Test the kickoff text for a blank value.
     *
     * @return void
     */
    public function testBlankKickoff()
    {
        $match = factory(Match::class)->make(['kickoff' => '']);

        $this->assertEquals('unknown', $match->kickoff);
    }



    /**
     * Test the H/A for H
     *
     * @return void
     */
    public function testHomeAwayH()
    {
        $match = factory(Match::class)->make(['ha' => 'H']);

        $this->assertEquals('H', $match->home_away);
    }

    /**
     * Test the H/A for A
     *
     * @return void
     */
    public function testHomeAwayA()
    {
        $match = factory(Match::class)->make(['ha' => 'A']);

        $this->assertEquals('A', $match->home_away);
    }

    /**
     * Test the H/A for N
     *
     * @return void
     */
    public function testHomeAwayN()
    {
        $match = factory(Match::class)->make(['ha' => 'N']);

        $this->assertEquals('N', $match->home_away);
    }

    /**
     * Test the H/A for N1
     *
     * @return void
     */
    public function testHomeAwayN1()
    {
        $match = factory(Match::class)->make(['ha' => 'N1']);

        $this->assertEquals('N', $match->home_away);
    }


    /**
     * Test the attendance text for a numerical value.
     *
     * @return void
     */
    public function testNumericalAttendance()
    {
        $match = factory(Match::class)->make(['attendance' => 52000]);

        $this->assertEquals('52,000', $match->attendance);
    }

    /**
     * Test the attendance text for a blank value.
     *
     * @return void
     */
    public function testBlankAttendance()
    {
        $match = factory(Match::class)->make(['attendance' => 0]);

        $this->assertEquals('N/A', $match->attendance);
    }
}
