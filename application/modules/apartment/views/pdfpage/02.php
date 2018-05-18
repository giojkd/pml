<?php $this->load->view('header'); ?>
<div class="page page-two">
	<h2>Parties</h2>
	<ul class="number">
		<li>
			<span>(1)</span> PML Services Ltd incorporated and registered in England and Wales with company number
			08994009 who's registered office is at 13 Southwick Mews, W2 1JG, London, Paddington,
			Email: administration@pmlservices.co.uk, Phone: 02072624267, Textphone: +44 75 3127 6756
			(Licensor).
		</li>

		<li>
			<span>(2)</span><br />Name: <?php echo $booking['name'].", ".$booking['family_name']; ?><br />
			
			Alternative Contact Address: <?php echo $booking['city_name'].", ".$booking['country_shortName'].", ".$booking['tenant_address']; ?><br />
                        Post Address: <?php echo $booking['tenant_post_address']; ?><br />
			Contact Telephone: <?php echo $booking['phone_no']; ?><br />
			Contact Email: <?php echo $booking['email']; ?><br />
			Post Tenancy Address:<br />
			(Occupant).<br />
		</li>
	</ul>
	

	<h2>Agreed terms</h2>
	<h2>1. Interpretation</h2>

	<ul>
		<li>
			The following definitions and rules of interpretation apply in this Licence.
			<ul>
				<li>1.1. Definitions:</li>
			</ul>
			<b>Building:</b> <?php echo $booking['name'].", ".$booking['family_name']; ?>
			<br /><br />

			<b>Common Parts:</b> any kitchen, bathroom, bike racks, gardens and such roads, paths, entrance
			halls, corridors, lifts, staircases, landing and other means of access in or upon the Building the
			use of which is necessary for obtaining access to and egress from the Property as designated from
			time to time by the Licensor.
			
			<br /><br />
			<b>Licence Fee:</b> the amount of £<?php echo $booking['monthly_fee']; ?> per calendar month.
			
			<br /><br />
			<b>Licence Commencement Date:</b> <?php echo date('d/m/Y', strtotime($booking['rent_from'])); ?>
			
			<br /><br />
			<b>Licence Fee Payment Date:</b> In advance on or before the <?php echo $booking['payment_date'];?>th of each calendar month to have
			reached the Licensor's Bank Account, whether or not it has been formally demanded. If
			International Payments sent from a foreign bank, please note that the payment needs to be
			prepared 5 days in advance to reach the account on time.
			
			<br /><br />
			<b>Licence Period:</b> the period from and including <?php echo date('d/m/Y', strtotime($booking['rent_from'])); ?> until the date on which this Licence
			is determined in accordance with clause 10.
		

			<br /><br />
			<b>Licensor's Bank Account:</b> Account Name: PML Services Ltd, Account Number: 00266574,
			Sort Code: 20-69-15, Reference: <?php echo $booking['name'].", ".$booking['family_name']; ?>

			<br /><br />
			<b>Licensor's International Bank Account:</b> PML Services Ltd, BIC: BARCGB22, IBAN:
			GB28BARC20691500266574 Reference: <?php echo $booking['name'].", ".$booking['family_name']; ?>

			<br /><br />
			<b>Licensor's Security Deposit Account:</b> Client Deposit Account, Account Number: 70145823,
			Sort Code: 20-69-15, Reference: <?php echo $booking['name'].", ".$booking['family_name']; ?>

			<br /><br />
			<b>Licensor's Security Deposit International Bank Account:</b> Client Deposit Account, BIC:
			BARCGB22, IBAN: GB30BARC20691570145823, Reference: <?php echo $booking['name'].", ".$booking['family_name']; ?>

			<br /><br />
			<b>Permitted Use:</b> residential short term use of the Property.

			<br /><br />
			<b>Property:</b> <?php echo $booking['name'].", ".$booking['family_name']; ?>

			<br /><br />
			<b>Security Deposit:</b> £<?php echo $booking['deposit_fee']; ?>

			<ul>
				<li>1.2. Clause and paragraph headings shall not affect the interpretation of this Licence.</li>
				<li>
					1.3. A person includes a natural person, corporate or unincorporated body (whether
					or not having separate legal personality).
				</li>
				<li>
					1.4. Unless the context otherwise requires, words in the singular shall include the
					plural and in the plural shall include the singular.
				</li>
				<li>
					1.5. Unless the context otherwise requires, a reference to one gender shall include a
					reference to the other genders.
				</li>
				<li>
					1.6. A reference to laws in general is a reference to all local, national and directly
					applicable supra-national laws as amended, extended or re-enacted from time to
					time and shall include all subordinate laws made from time to time under them
					and all orders, notices, codes of practice and guidance made under them.
				</li>
				<li>
					1.7. Unless otherwise specified, a reference to a statute or statutory provision is a
					reference to it as amended, extended or re-enacted from time to time and shall
					include all subordinate legislation made from time to time under that statute or
					statutory provision and all orders, notices, codes of practice and guidance made
					under it.
				</li>
				<li>
					1.8. Any obligation on a party not to do something includes an obligation not to
					allow that thing to be done and an obligation to use best endeavors to prevent
					that thing being done by another person.
				</li>
				<li>
					1.9. Any words following the terms including, include, in particular, for example or
					any similar expression shall be construed as illustrative and shall not limit the
					sense of the words, description, definition, phrase or term preceding those terms.
				</li>

				<li>
					1.10. A working day is any day which is not a Saturday, a Sunday, a bank holiday or a
					public holiday in England.
				</li>
			</ul>
		</li>
	</ul>

	<h2>2. Licence to Occupy</h2>
	<ul>
		<li>
			2.1. Subject to clause 3 and clause 10, the Licensor permits the Occupant to Occupy
			the Property for the Permitted Use only for the Licence Period in common with
			the Licensor (so far as is not inconsistent with the rights given to the Occupant to
			use the Property for the Permitted Use).
		</li>
		<li>
			2.2. The Occupant acknowledges that:
		</li>
		
		<li>
			<ul>
				<li>
					a) the Occupant shall occupy the Property as a Occupant and that no relationship of landlord
					and Occupant is created between the Licensor and the Occupant by this Licence;
				</li>
				<li>
					b) the Licensor retains control, possession and management of the Property and the
					Occupant has no right to exclude the Licensor from the Property;
				</li>
				<li>
					c) the Licence to Occupy granted by this agreement is personal to the Occupant and is not
					assignable and the rights given in clause 2 may only be exercised by the Occupant; and
				</li>
				<li>
					d) the Licensor shall be entitled at any time on giving not less than 1 month notice to
					require the Occupant to transfer to alternative space elsewhere within the Building and
					the Occupant shall comply with such requirement. In the event that Notice is served PML
					Services will undergo measures to match the current standard of Occupation. If this is not
					possible then the Occupant must respect the notice and vacate on the defined date.
				</li>
			</ul>
		</li>
	</ul>

	<h2>3. Occupant's Obligations</h2>
	<ul>
		<li>The Occupant agrees and undertakes:</li>
		<ul>
			<li>
				3.1. to pay to the Licensor an initial administration fee of £100.00 and an agent's fee
				of £100.00, totalling £200.00 (or total administration fee of £50.00 if this is a
				renewal contract) which is payable with the Licence Fee on the Licence
				Commencement Date;
			</li>
			<li>
				3.2. to pay to the Licensor £75.00 in respect of Check Out Inventory which is payable
				on the Licence Termination Date. The Occupant can elect to pay this at any point
				during the Licence period;
			</li>
			<li>
				3.3. to pay to the Licensor the Security Deposit to the Licensor's Security Deposit
				Account on the Licence Commencement Date which will be retained by the
				Licensor as security for any non-payment of Licence Fees and for the
				consideration of any damage caused to the Building or the Property by the
				Occupant. The Security Deposit is not a substitute for the payment of the Licence
				Fee. On the signing of this Agreement, the Occupant shall pay to the Licensor
				the Deposit as security for any other breach by the Occupant of the Occupant’s
				agreements and obligations under this Agreement. Any interest earned on the
				deposit will belong to the Licensor to cover administrative cost. At the end of the
				Licence Period the Licensor shall be entitled to withhold from the Security
				Deposit such proportion of the Security Deposit as may reasonably be necessary
				to:
			</li>

			</li>
				<ul>
					<li>a) set off any unpaid Licence Fees or other Fees, which if unpaid on time is a breach of this
					Licence;</li>
					
					<li>b) make good any damage to the Property or the contents (except for fair wear and tear)
					caused by the Occupant's failure to take reasonable care of the Property;</li>
					
					<li>c) replace any of the contents which may be missing from the Property;</li>
					
					<li>e) pay for the Property and the contents to be cleaned if the Occupant is in breach of its
					obligations, and pay for the emergency call out rate for a professional cleaner if the
					Property is not left in a clean manner at the end of the Occupant's occupation;</li>
					
					<li>f) pay for the emergency call out rate for a professional cleaner if the Property is not left in
					a clean manner during Occupant's occupation;</li>
					
					<li>g) repair or repaint walls due to plugs, large nails or any unreasonable number of holes in
					the walls including the repainting of damaged walls. Where marks have appeared on the
					wall during the Occupant's occupation. Instead of repainting the Property the Licensor
					may propose to deduct from the Security Deposit a reasonable proportion of the total cost
					the Licensor will be charged for having the walls repainted. Normal quotation for large
					room is £150.00 and small room is £100.00;</li>
					
					<li>h) replace stained mattress where stains have appeared on the mattress during the Licence
					Period, instead of replacing the mattress the Licensor may propose to deduct from the
					Security Deposit a reasonable proportion of the total cost of the mattress. Normal
					quotation for replacing double bed mattress is £110.00 including delivery and disposal
					costs;</li>
					
					<li>i) unblocking toilet sinks and drains;</li>
					
					<li>j) replacing damaged or missing doors, windows, mirrors, furniture or light fixtures;</li>
					
					<li>k) repairing linoleum, rugs and other flooring due to cuts, burns or water damage;</li>
					
					<li>l) pay for costs of extermination of pests and insects;</li>
					<li>m) pay for loss of keys;</li>
					<li>n) Subject to any deductions made by the Licensor, the Security Deposit will be returned to
					the Occupant within 14 working days after the termination of the Licence however it shall
					end. In the event of a new Licence being produced then the Security Deposit, subject to
					any increase, will be transferred to the new Licence;</li>
					<li>o) If the Occupant wishes to receive the return of the Security Deposit to foreign account,
					a bank charge of £15.00 will be deducted from the Security Deposit;</li>
				</ul>
			</li>

			<li>
				3.4. to ensure, if any Security Deposit is paid using an international bank account to
				the Licensor's Security Deposit International Bank Account, the Occupant will
				have to add £6.00 to the Security Deposit in respect of international transaction
				fees. If any sums received by the Licensor are less than the expected amount due
				to any currency conversion then the Licensor will be entitled to deduct the
				outstanding sum from the Security Deposit that would be returned to the
				Occupant at the end of the Licence Period;
			</li>
			
			<li>
				3.5. to pay to the Licensor the Licence Fee payable without any deduction in advance
				on the Licence Fee Payment Date to Licensor's Bank Account, unless otherwise
				instructed by the Licensor; and,
			</li>

			<li>
				<ul>
					<li>a) to ensure if any Licence Fee is paid using an international bank account to the Licensors
					International Bank Account, the Occupant will have to add £6.00 to the Licence Fee in
					respect of international transaction fees. If any sums received by the Licensor are less
					than the expected amount due to any currency conversion then the Licensor will be
					entitled to deduct the outstanding sum from the Security Deposit;</li>
					<li>b) to ensure the Licence Fee is received by the Licensor on the Licence Fee Payment Date.
					If the Licence Fee is not received by the Licensor on the Licence Fee Payment Date then
					a fee of £10.00 for each day the Licence Fee is overdue will apply;</li>
					<li>c) Not to withhold any payments of the Licence Fee or any other sums payable under this
					Licence on the grounds that the Licensor is in breach of their obligations to the Occupant
					whether under the terms of this Licence or imposed by statute or otherwise;</li>
				</ul>
			</li>

			<li>3.6. to keep the Property clean, tidy and clear of rubbish;</li>

			<li>
				3.7. to observe any reasonable rules and regulations the Licensor makes and notifies
				to the Occupant from time to time governing the Occupant's use of the Property
				and the Common Parts;
			</li>

			<li>
				3.8. to leave the Property in a clean and tidy condition and to remove the Occupant's
				furniture equipment and goods from the Property at the end of the Licence
				Period;
			</li>

			<li>
				3.9. to indemnify the Licensor and keep the Licensor indemnified against all losses,
				claims, demands, actions, proceedings, damages, costs, expenses or other
				liability in any way arising from:
			</li>
			<li>
				<ul>
					<li>a) this Licence;</li>
					<li>b) any breach of the Occupant's undertakings contained in clause 3; and/or</li>
					<li>c) the exercise of any rights given in clause 2;</li>
				</ul>
			</li>

			<li>3.10. to provide the Licensor with their correct contact details and promptly respond to
			any correspondence via email, phone, fax, letter or otherwise;
			3.11. to allow the Licensor to conduct viewings at the Property upon the Licensor
			providing the Occupant with reasonable notice and ensure the Property is kept
			clean and tidy when the Licensor conducts viewings of the Property;</li>
			
			<li>3.12. to observe all rules and regulations advised by the Licensor regarding the use and
			care of the of the Building, parking lot and other common facilities that are
			provided;</li>
			
			<li>3.13. to keep the Property in good repair and condition, in a clean and tenable state
			and in good decorative order and clean the Property 2 times per week. If the
			Property is reported as unclean at any time, a cleaner will be sent immediately at
			the Occupant's expense;</li>
			
			<li>3.14. to use their own mattress protector under the bed sheets;</li>
			
			<li>3.15. to keep all belongings, suitcases, clothes, shoes and other personal belongings in
			the Property and not in any stairwells or common areas;</li>
			
			<li>3.16. to ensure the Property, and particularly the bathroom and kitchen is well
			ventilated to ensure the prevention of damp and mould. In the event of any
			mould the Occupant is responsible to buy products to remove the mould;</li>
			
			<li>3.17 to keep the floors of the Property clean, by wiping any spills immediately and
			using soap and water;</li>
			
			<li>3.18 to prevent any pests, mice, rats, bedbugs or unwanted insects in the Property. If
			pests or other unwanted insects infest the Property, the Occupant shall arrange
			pest control to attend the Property immediately at the Occupant's expense, or the
			Licensor will arrange this at the Occupant's expense;</li>
			
			<li>3.19. to notify the Licensor of any damage to any furnishings supplied by the Licensor
			or damage to anything that may significantly interfere with the normal use of the
			Property;</li>
			
			<li>3.20. subject to the Licensor's obligations defined below, to ensure all electrical, gas
			and other appliances are kept in good working order and to pay for the
			immediate replacement of any parts which have become defective through
			negligence or ill-treatment by the Occupant or any invitee of the Occupant and to
			replace all fluorescent tubes batteries and electrical fuses and light-bulbs which
			become defective;</li>
			
			<li>3.21. to keep all smoke alarms in good working order and replace any batteries where
			necessary and inform the Licensor promptly if the smoke alarm requires
			maintenance or repair;</li>
			
			<li>3.22. to dispose refuse and rubbish and do not leave it in the Property overnight unless
			other information has been given by the Licensor;</li>
			
			<li>3.23. to be responsible for any cost in regards to sink unblockage;</li>
			
			<li>3.24. to keep cleansed and free from obstruction all sewers drains sanitary apparatus
			water and waste pipes air vents and ducts exclusively serving or forming part of
			the Premises unless the obstruction is due to a defect that forms part of the
			repairing obligations of the freeholder;</li>
			
			<li>3.25. to inform the Licensor if they see anyone smoking inside the Property or, outside
			the Property close to an open window; as this is strictly prohibited;</li>
			
			<li>3.26. to pay the Licensor any costs incurred as a result of any breach of any terms and
			conditions in this agreement;</li>
			
			<li>3.27. to pay £50.00 to the Licensor for every letter sent from the Licensor to the
			Occupant concerning breaches of any terms in this Licence;</li>
			
			<li>3.28. to pay the Licensor the cost of repairs to correct any damage caused to the
			Property by the Occupant during the Licence Period;</li>
			
			<li>3.29. to pay the Licensor the cost of any fixtures, fittings and repairs of any
			mechanical and electrical appliances belonging to the Building arising from
			misuse or negligence by the Occupant, or their visitors;</li>
			
			<li>
				3.30. to pay the Licensor's legal costs on demand following a breach of the Occupant's
				obligations, including any costs to recover the Licence Fee;
			</li>
			
			<li>
				3.31. if either the whole or part of the Premises is destroyed or damaged by fire,
				tempest, flood, explosion or other cause during the Licence Period and the total
				or part of the insurance money due under the freeholders policy which covers
				such risks is not paid due to an act or failure of the Occupant, their visitors or
				contractors then the Occupant will pay the sums that are irrecoverable in addition
				to the Licence Fee to the Licensor and the reasonable professional fees incurred
				by the freeholder;
			</li>
			
			<li>
				3.32. to ensure the Property is available for viewing four weeks prior to the end of the
				Licence Period, and the Occupant will be informed by text message from the
				Licensor prior to each viewing. All occupants in the Building will be informed
				when a viewing period starts but not informed of each and every viewing unless
				they are the Occupant. The Licensor reserves the right to enter Common Parts of
				the Building;
			</li>
			
			<li>3.33. to bleed radiators if necessary;
			<li>
				3.34. where the Occupant requests a repair and on inspection the problem has been
				caused by a failure on the part of the occupiers (for example drains blocked by
				the occupier's waste or inappropriate or unauthorised use of any appliances), the
				Licencesee agrees to be responsible for the reasonable costs of the contractor’s
				visit. The Occupant shall ensure they have sufficient means to cover their liability
				for accidental damage to the property, its furniture, fixtures, and fittings and
				undertakes to repay or arrange for adequate insurance to cover the repayment to
				the Licensor all sums not payable by the Licensor's Insurers, or any excess sum
				payable under the Licensor's insurance policy, in respect of any damage or loss
				to the property or the contents arising as a result of accidental damage misuse or
				negligence by the Occupant or any invitee of the Occupant or of any default or
				breach of any of the Terms of this Agreement. This is in addition to any optional
				cover arranged for the Occupant's own belongings as outlined in clause 1.37
				below.
			</li>
			
			<li>3.35. The Occupant must not:</li>
			<li>
				<ul>
					<li>a) tamper with the boiler or timer as set on the heating system serving the Property;</li>
					<li>b) use a landline phone in the Property;</li>
					<li>c) hang clothes outside the Property or in front of windows visible from street view;</li>
					<li>d) allow any guests to stay in the Property for more than 5 nights without written permission
					from the Licensor;</li>
					<li>e) make or allow to be made any noise or nuisance, which in the reasonable opinion of the
					Agent, disturbs the comfort or convenience of other occupiers of the Building;</li>
					<li>f) make or allow to be made any noise or nuisance which, in the reasonable opinion of the
					Licensor, may be heard outside the Property by neighbours between 10 pm and 8 am;</li>
					<li>g) make any alteration or addition whatsoever to the Property and not to apply for any
					planning permission in respect of the Property;</li>
					<li>h) display any advertisement, signboards, nameplate, inscription, flag, banner, placard,
					poster, signs or notices at the Property or elsewhere in the Building;</li>
					<li>i) do or permit to be done on the Property anything which is illegal immoral or improper or
					which may be or become a nuisance (whether actionable or not), annoyance,
					inconvenience or disturbance to the Licensor or to other occupiers of the Building or any
					owner or occupier of neighbouring property and not to have any restricted or illegal
					drugs in the Property, except where prescribed by a medical practitioner;</li>
					<li>j) cause or permit to be caused any damage to the Property, Building or any neighboring
					property; or any property of the other occupiers of the Building or any neighboring
					property;</li>
					<li>k) obstruct the Common Parts, make them dirty or untidy or leave any rubbish on them;</li>
					<li>l) do anything that will or might constitute a breach of any necessary consents affecting the
					Property or which will or might vitiate in whole or in part any insurance in respect of the
					Building from time to time;</li>
					<li>m) do anything on or in relation to the Property that would or might cause the Licensor to be
					in breach of the Occupant's covenants and the conditions contained in the Agreement
					between the Licensor and the freeholder of the Building; and</li>
					<li>n) cause any antisocial behaviour or damage to the Property or that of the neighbours
					property;</li>
					<li>o) smoke inside the Property or outside the Building near a window. If smoking outside
					away from windows of the Property, cigarette butts must not be left on the ground and
					ash must not be left on walls or tables;</li>
					<li>p) put sanitary towels or anything other than toilet paper into the toilets, since this will
					cause a blockage to the system;</li>
					<li>q) permit oil, grease or other harmful or corrosive substances to enter any of the sanitary
					appliances or drains within the Property, other than those substances reasonably used for
					the cleaning of the Property;</li>
					<li>r) keep or use any paraffin heater liquefied petroleum gas heater or portable heater in the
					Property nor to store or bring upon the Property any articles which are particularly
					combustible inflammable or dangerous in nature apart from those required for general
					household use;</li>
					<li>s) keep more than a small amount of petrol if it is required for a lawn mower on the
					Property and to ensure that the petrol is stored in an air tight container and kept in an
					outbuilding at the Property;</li>
					<li>t) use any barbecue or grill belongings near the Property;</li>
					<li>u) transfer this Licence, part with or share occupation of the Property without written
					consent of the Licensor.</li>
				</ul>
			</li>
		</ul>
	</ul>

	<h2>4. Licensor’s Obligations</h2>

	<ul>
		<li>The Licensor agrees and undertakes:</li>
		<li>
			<ul>
				<li>
					4.1. to ensure that all gas appliances, flues and installation in the Building are
					checked by a UK registered technician on an annual basis;
				</li>
				<li>
					4.2. to carry out any repairing obligations including keeping in repair and proper
					working order:
				</li>
				<li>
					<ul>
						<li>a) the structure and exterior of the Property; and</li>
						<li>b) the installations for the supply of water, gas</li>
					</ul>
				</li>
				<li>
					4.3. If the Property, or any part of the Property, are partially damaged by fire or other
					casualty not due to the Occupant's negligence or wilful act or that of the
					Occupant's visitor; if the Licensor's reasonably decides to repair or reinstate the
					Property, there will be an abatement of the Licence Fee corresponding with the time during which, and the extent to which, the Property may have been untenable.
				</li>

				<li>
					4.4. If the Property should be damaged other than by the Occupant's negligence or that
					of the Occupant's visitor; and the Licensor decides not to rebuild or repair the
					Property, the Licensor may end this agreement by giving appropriate notice.
				</li>

				<li>
					4.5. If replaceable or irreplaceable furniture, electrics or such items break or are
					damaged, not due to the Occupant's negligence or wilful act, the damaged item
					will be replaced as soon as possible without compensation to the Occupant for
					not being able to use the item.
				</li>
			</ul>
		</li>
	</ul>

	<h2>5. Improvements or Repairs</h2>
	<ul>
		<li>The Occupant must obtain written permission from the Licensor prior to doing any of the following:</li>
		<li>
			<ul>
				<li>5.1. applying adhesive materials, or inserting nails or hooks in walls or ceilings;</li>
				<li>5.2. painting, wallpapering, redecorating or in any way significantly altering the
				appearance of the Property;</li>
				<li>5.3. changing the amount of heat or power normally used in the Property as well as
				installing additional electrical wiring or heating units;</li>
				<li>5.4. affixing to or erecting upon or near the Property any radio or TV antenna or
				tower.</li>
			</ul>
		</li>
	</ul>

	<h2>6. Insurance</h2>
	<ul>
		<li>6.1. The Occupant is hereby advised and understands that his/her personal property is
		not insured by the Licensor for either damage or loss, and the Licensor assumes
		no liability for any such loss.</li>
		<li>6.2. The Occupant agrees that the Licensor will not be liable or responsible in any
		way for any personal injury or death that may be suffered or sustained by the
		Occupant or by any person for whom the Occupant is responsible who may be on
		the Property for any loss of or damage or injury to any property, including cars
		and contents thereof belonging to the Occupant or to any other person for whom
		the Occupant is responsible.</li>
		<li>6.3. The Occupant shall not do anything to or on the Property that has the effect of
		invalidating the insurance that the freeholder has taken out in respect of the
		Property.</li>
	</ul>

	<h2>7. Utilities and Outgoings</h2>
	<ul>
		<li>7.1. The Occupant is only liable to pay the cost if the consumption exceeds £50.00 for
		the electricity and £150.00 for the gas per month if applicable. The Occupant is
		responsible for ensuring a reasonable gas and electricity consumption.</li>
		<li>7.2. The Occupant is not liable to pay any charges for water and sewerage services
		used by them at the Property.</li>
		<li>7.3. The Occupant shall comply with all laws and recommendations of the relevant
		suppliers relating to the use of those services and utilities.</li>
		<li>7.4. Where the Occupant allows by specific instruction, the utility or other services to
		be cut off, the Occupant shall pay the costs associated with reconnecting or
		resuming those services.</li>
		<li>7.5. The Occupant is not liable pay the Council Tax for the Property.</li>
	</ul>

	<h2>8. WIFI</h2>
	<ul>
		<li>8.1. The Occupant shall have the benefit of WIFI under this Licence.</li>
		<li>8.2. The Occupant should note the following in respect of unlimited WIFI:</li>
		<li>
			<ul>
				<li>a) Occasionally there are problems with the internet connection and the internet may
				disconnect and may need to be reconnected as appropriate. In this occasion the Occupant
				should contact the Licensor promptly for information about the internet account and then
				contact the internet provider directly to solve the problem with them.</li>
				<li>b) The Occupant may have to arrange and be present in the Property where an engineer
				appointment is necessary.</li>
				<li>c) If a major fault occurs and the internet is not active for any reason and for more than 14
				days, a wireless router with limited data can be requested to be shared by all occupiers in
				the Building.</li>
				<li>d) It is the Occupant's responsibility to check with the Licensor if there is anything that
				could cause slower, limited or no internet connection.</li>
				<li>e) To prevent loss of work or information, the Licensor advises the Occupant to prepare a
				back-up solution but is not responsible for ensuring this is possible or a viable solution.</li>
			</ul>
		</li>
	</ul>

	<h2>9. Licensor’s Right to Enter the Property</h2>
	<ul>
		<li>The Licensor reserves the right to enter the Property on giving reasonable notice in
		writing to the Occupant:</li>
		<li>
			<ul>
				<li>a) to inspect the condition and state of repair of the Property;</li>
				<li>b) to carry out the Licensor's Obligations under this Licence;</li>
				<li>c) take photos of the Property for advertising purposes;</li>
				<li>d) to carry out repairs or alterations to the next door premises;</li>
				<li>e) to take gas, electricity or water meter readings;</li>
				<li>f) to show prospective occupiers around the Property.</li>
				<li>9.1. The Licensor has the right to retain keys to the Property.</li>
			</ul>
		</li>
	</ul>

	<h2>10. Termination</h2>
	<ul>
		<li>This Licence shall end on the earliest of:</li>
		<li>
			<ul>
				<li>10.1. <?php echo date('M Y', strtotime($booking['rent_to'])); ?>; and</li>

				<li>
					<ul>
						<li>a) the expiry of a two weeks’ notice given by the Licensor to the Occupant at any time of
						breach of any of the Occupant's obligations contained in clause 3; and</li>
						<li>b) the expiry of not less than 1 months' notice given by the Licensor to the Occupant.</li>
					</ul>
				</li>
				
				<li>10.2. Termination of this Licence shall not affect the rights of either party in
				connection with any breach of any obligation under this Licence which existed at
				or before the date of termination.</li>
				
				<li>10.3. The Occupant must inform the Licensor if they do not wish to enter into a new
				Licence after the expiry of the Licence Period, by providing the Licensor with
				one month’s written notice. If the Licence is to be extended an administration fee
				of £50.00 will be payable by the Occupant, to the Licensor. If a new Licence is
				agreed upon then the Security Deposit, subject to any increase, will transfer to
				the new Licence.</li>
				
				<li>10.4. At the end of the Licence Period all of the obligations and responsibilities set out
				in this Licence will cease, subject to any claims made by either party against the
				other in respect of any breach of any terms or conditions of this Licence.</li>
				
				<li>10.5. At the end of the Licence Period, the Occupant shall return the Property and the
				contents to the Occupant in the condition required by this Licence.</li>
				
				<li>10.6. The Occupant shall provide the Licensor with a forwarding address once the
				Licence has come to an end.</li>
				
				<li>10.7. The Occupant shall remove all personal possessions from the Property at the end
				of the Licence Period and leave the Property including the Common Parts of the
				Building in a clean and tidy manner by 11 am that day. If the Licensor does not
				receive the keys by 11 am, the Occupant will be liable to pay the Licence Fee at
				the daily rate until the Licensor receives the keys.</li>
				
				<li>10.8. The Occupant shall return keys according to instructions provided by the
				Licensor.</li>
				
				<li>10.9. The Occupant will be responsible for meeting all reasonable removal and storage
				charges of items left in the Property at the end of the Licence Period. The
				Licensor will remove and store the items for a maximum of 7 days. The Licensor
				will notify the Occupant that this has been done at the Occupant's last known
				email address. If the items are not collected within 7 days, the Licensor may
				dispose of the items and the Occupant will be liable for the reasonable costs of
				disposal.</li>
			</ul>
		</li>
	</ul>

	<h2>11. Notices</h2>
	<ul>
		<li>11.1. Any notice sent to the Licensor under or in connection with this Licence shall be
		deemed to have been properly served if:</li>
		<li>
			<ul>
				<li>a) sent by first class post to the Agent’s address stated in the Parties clause.</li>
				<li>b) left at the Agent's address stated in the Parties clause; or</li>
				<li>c) sent to the Agent's e-mail address stated in the Parties clause.</li>
			</ul>
		</li>
		<li>11.2. Any notice sent to the Occupant under or in connection with this Licence shall be
		deemed to have been properly served if:</li>
		<li>
			<ul>
				<li>a) sent by first class post to the Property;</li>
				<li>b) left at the Property; or</li>
				<li>c) sent to the Occupant e-mail address stated in the Parties clause.</li>
			</ul>
		</li>
		<li>11.3. This clause does not apply to the service of any proceedings or other documents
		in any legal action or, where applicable, any arbitration or other method of
		dispute resolution.</li>
	</ul>

	<h2>12. Limitation of Licensor's liability</h2>
	<ul>
		<li>12.1. Subject to clause 12.2, the Licensor is not liable for:</li>
		<li>
			<ul>
				<li>a) the death of, or injury to the Occupant, or invitees to the Property; or</li>
				<li>b) damage to any property of the Occupant or that of the Occupant's other invitees to the
				Property; or</li>
				<li>c) any losses, claims, demands, actions, proceedings, damages, costs or expenses or other
				liability incurred by Occupant or the Occupant's other invitees to the Property in the
				exercise or purported exercise of the rights granted by clause 2.</li>
			</ul>
		</li>
		<li>12.2. Nothing in clause 12.1 shall limit or exclude the Licensor's liability for:</li>
		<li>
			<ul>
				<li>a) death or personal injury or damage to property caused by negligence on the part of the
				Licensor or its employees or agents; or</li>
				<li>b) any matter in respect of which it would be unlawful for the Licensor to exclude or
				restrict liability.</li>
			</ul>
		</li>
	</ul>

	<h2>13. Third party rights</h2>
	<ul>
		<li>A person who is not a party to this Licence shall not have any rights under the Contracts (Rights
		of Third Parties) Act 1999 to enforce any term of this Licence.</li>
	</ul>

	<h2>14. Governing law</h2>
	<ul>
		<li>This Licence and any dispute or claim arising out of or in connection with it or its subject matter
		or formation (including non-contractual disputes or claims) shall be governed by and construed
		in accordance with the law of England and Wales.</li>
	</ul>

	<h2>15. Jurisdiction</h2>
	<ul>
		<li>Each party irrevocably agrees that the courts of England and Wales shall have exclusive
		jurisdiction to settle any dispute or claim arising out of or in connection with this Licence or its
		subject matter or formation (including non-contractual disputes or claims).</li>
	</ul>

	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<p>This Licence has been entered into on the date stated at the beginning of it.</p>

	<h2><u>Note for Occupant:</u></h2>
	<h2>
		You should read the content of this Licence carefully. If you do not understand the terms
		in this Licence; you are strongly advised to ask the Licensor for an explanation of the terms
		before signing, or to seek independent advice before signing.
	</h2>
	<br /><br />
	<br /><br />
	<table width="100%">
		<tr>
			<td>
				<h2>Signed by</h2>
				<p>For and on behalf of PML Services Ltd</p>
			</td>
			<td>
				<h2>........................</h2>
				<h2>Licensor</h2>
			</td>
		</tr>

		<tr>
			<td><br /><br />
				<p>Signed by <?php echo $booking['name'].", ".$booking['family_name']; ?></p>
			</td>
			<td><br /><br />
				<h2>Occupant</h2>
			</td>
		</tr>
	</table>
</div><!--./page page-one-->
<?php $this->load->view('footer'); ?>